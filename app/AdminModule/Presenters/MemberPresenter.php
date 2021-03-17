<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberPresenter.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 0:11
 */

namespace App\AdminModule\Presenters;

use App\Form\KCForm;
use App\Model\Facades\Member2Departments2FunctionsFacade;
use App\Model\Facades\Member2FunctionFacade;
use App\Model\Facades\Member2MeetingFacade;
use App\Model\Facades\MemberFacade;
use App\Model\Managers\BranchManager;
use App\Model\Managers\CarManager;
use App\Model\Managers\CauseManager;
use App\Model\Managers\MemberManager;
use App\Services\ProfilePhotoService;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;
use Nette\Utils\Random;
use Tracy\Debugger;
use Tracy\ILogger;

/**
 * Class MemberPresenter
 *
 * @package App\AdminModule\Presenters
 */
class MemberPresenter extends Presenter
{
    /**
     * @var string[] $memberTypes
     */
    public static $memberTypes = [
        0 => 'Čestné členství',
        1 => 'Plné členství',
        2 => 'Neplacené členství',
        3 => 'Zkušební členství',
        4 => 'Zrušené členství'
    ];

    /**
     * @var string[] $memberActive
     */
    public static $memberActive = [
        0 => 'Neaktivní',
        1 => 'Aktivní'
    ];

    public static $memberGender = [
        'm' => 'Muž',
        'f' => 'Žena'
    ];

    /**
     * @var BranchManager $branchManager
     */
    private BranchManager $branchManager;

    /**
     * @var CauseManager $causeManager
     */
    private CauseManager $causeManager;

    /**
     * @var CarManager $carManager
     */
    private CarManager $carManager;

    /**
     * @var Member2Departments2FunctionsFacade $member2Departments2FunctionsFacade
     */
    private Member2Departments2FunctionsFacade $member2Departments2FunctionsFacade;

    /**
     * @var MemberFacade $memberFacade
     */
    private MemberFacade $memberFacade;

    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * @var Member2FunctionFacade $member2FunctionFacade
     */
    private Member2FunctionFacade $member2FunctionFacade;

    /**
     * @var Member2MeetingFacade $member2MeetingFacade
     */
    private Member2MeetingFacade $member2MeetingFacade;

    /**
     * @var ProfilePhotoService
     */
    private ProfilePhotoService $profilePhotoService;

    /**
     * MemberPresenter constructor.
     *
     * @param BranchManager $branchManager
     * @param CauseManager $causeManager
     * @param CarManager $carManager
     * @param Member2Departments2FunctionsFacade $member2Departments2FunctionsFacade
     * @param MemberFacade $memberFacade
     * @param MemberManager $memberManager
     * @param Member2FunctionFacade $member2FunctionFacade
     * @param Member2MeetingFacade $member2MeetingFacade
     * @param ProfilePhotoService $profilePhotoService
     */
    public function __construct(
        BranchManager $branchManager,
        CauseManager $causeManager,
        CarManager $carManager,
        Member2Departments2FunctionsFacade $member2Departments2FunctionsFacade,
        MemberFacade $memberFacade,
        MemberManager $memberManager,
        Member2FunctionFacade $member2FunctionFacade,
        Member2MeetingFacade $member2MeetingFacade,
        ProfilePhotoService $profilePhotoService
    ) {
        parent::__construct();

        $this->branchManager = $branchManager;
        $this->causeManager = $causeManager;
        $this->carManager = $carManager;
        $this->memberFacade = $memberFacade;
        $this->memberManager = $memberManager;
        $this->member2FunctionFacade = $member2FunctionFacade;
        $this->member2MeetingFacade = $member2MeetingFacade;
        $this->profilePhotoService = $profilePhotoService;
        $this->member2Departments2FunctionsFacade = $member2Departments2FunctionsFacade;
    }

    public function startup()
    {
        parent::startup();

        if (!$this->user->loggedIn) {
            $this->flashMessage('Nejste přihlášený', 'warning');
            $this->redirect('Login:default');
        }
    }

    public function renderDefault()
    {
        $members = $this->memberFacade->getAll();

        $this->template->members = $members;
    }

    /**
     * @param int|null $id
     */
    public function actionEdit(int $id = null)
    {
        $cars = $this->carManager->getPairsForSelect();
        $branches = $this->branchManager->getPairsForSelect();

        $this['memberForm-carId']->setItems($cars);
        $this['memberForm-branchId']->setItems($branches);

        if ($id) {
            $member = $this->memberManager->getByPrimaryKey($id);

            if (!$member) {
                $this->error('Člen KC nenalezen.');
            }

            $this['memberForm']->setDefaults($member);
        }
    }

    public function renderEdit(int $id = null)
    {
        if ($id) {
            $functions = $this->member2FunctionFacade->getByLeft($id);
            $causes = $this->causeManager->getByMemberId($id);
            $meetings = $this->member2MeetingFacade->getByLeftId($id);
            $member = $this->memberManager->getByPrimaryKey($id);
            $departments2Functions = $this->member2Departments2FunctionsFacade->getByMemberId($id);
        } else {
            $functions = [];
            $causes = [];
            $meetings = [];
            $member = null;
            $departments2Functions = [];
        }

        $this->template->functions = $functions;
        $this->template->causes = $causes;
        $this->template->meetings = $meetings;
        $this->template->member = $member;
        $this->template->departments2Functions = $departments2Functions->departments;
        $this->template->photoDir = $this->profilePhotoService->getRelativeDir();
    }

    /**
     * @param int $id
     */
    public function actionDelete(int $id)
    {
        $this->memberManager->deleteByPrimaryKey($id);
        $this->flashMessage('Člen KC byl smazán.', 'success');
        $this->redirect('Member:default');
    }

    public function actionDeleteProfilePhoto(int $id)
    {
        $member = $this->memberManager->getByPrimaryKey($id);

        if (!($member->profilePhoto && $member->profilePhotoExtension)) {
            $this->flashMessage('Profilová fotografie není potřeba mazat', 'info');
        }

        $memberPhotoPath = $this->profilePhotoService->getDir() . $member->profilePhoto . '.' . $member->profilePhotoExtension;

        if (!file_exists($memberPhotoPath)) {
            $this->flashMessage('Profilová fotografie není potřeba mazat', 'info');
        }

        try {
            $profilePhotoData = [
                'profilePhoto' => null,
                'profilePhotoExtension' => null
            ];

            FileSystem::delete($memberPhotoPath);
            $this->memberManager->updateByPrimaryKey($id, $profilePhotoData);
            $this->flashMessage('Profilová fotografie byla smazána', 'success');
        } catch (\Nette\IOException $e) {
            $this->flashMessage('Profilovou fotografii se nepodařilo smazat', 'danger');
            Debugger::log($e->getMessage(), ILogger::WARNING);
        }

        $this->redirect('Member:edit', $id);
    }

    /**
     * @return Form
     */
    public function createComponentMemberForm() : Form
    {
        $form = new KCForm();

        $form->addText('name', 'Jméno')
            ->setRequired('Jméno je povinné');
        $form->addText('surname', 'Přijmení')
            ->setRequired('Přijmení je povinné');

        $form->addRadioList('gender', 'Pohlaví', self::$memberGender)
            ->setRequired('Pohlaví je povinné');

        $form->addText('nick', 'Přezdívka')
            ->setNullable();

        $form->addInteger('birthYear','Rok narození')
            ->addRule(Form::MIN, 'Rok narození nemůže být před rokem 1900', 1900)
            ->addRule(Form::MAX, 'Rok narození nemůže být vyšší než aktuální rok', date('Y'))
            ->setNullable();

        $form->addCheckbox('active', 'Aktivní');

        $form->addRadioList('type', 'Typ členství', self::$memberTypes)
            ->setRequired('Typ členství je povinné');

        $form->addTextArea('description', 'Popis');

        $form->addUpload('profilePhoto', 'Profilová fotografie')
            ->addRule($form::IMAGE, 'Profilová fotografie musí být JPEG, PNG, GIF or WebP.');

        $form->addSelect('carId', 'Auto')
            ->setPrompt('Vyberte auto');

        $form->addSelect('branchId', 'Pobočka')
            ->setPrompt('Vyberte pobočku');

        $form->addSubmit('send','Uložit Člena KC');

        $form->onSuccess[]= [$this, 'memberFormSuccess'];

        return $form;
    }

    /**
     * @param Form $form
     * @param ArrayHash $values
     * @param $
     */
    public function memberFormSuccess(Form $form, ArrayHash $values, )
    {
        $id = $this->getParameter('id');

        $profilePhoto = $values->profilePhoto;
        unset($values->profilePhoto);

        if ($profilePhoto->hasFile()) {
            if ($id) {
                $member = $this->memberManager->getByPrimaryKey($id);

                if ($member->profilePhoto && $member->profilePhotoExtension) {
                    $memberPhotoPath = $this->profilePhotoService->getDir() . $member->profilePhoto . '.' . $member->profilePhotoExtension;

                    if (file_exists($memberPhotoPath)) {
                        unlink($memberPhotoPath);
                    }
                }
            }

            $name = $profilePhoto->getName();
            $explodedName = explode('.', $name);
            $countExplodedName = count($explodedName);
            $extension = $explodedName[$countExplodedName - 1];
            $newName = Random::generate();
            $profilePhotoPath = $this->profilePhotoService->getDir() . $newName . '.' . $extension;

            $profilePhoto->move($profilePhotoPath);

            $image = Image::fromFile($profilePhotoPath);
            $image->resize(500, 300);
            $image->sharpen();
            $image->save($profilePhotoPath);

            $values->profilePhoto = $newName;
            $values->profilePhotoExtension = $extension;
        }

        if ($id) {
            $this->memberManager->updateByPrimaryKey($id, (array) $values);
            $this->flashMessage('Člen KC byl aktualizován', 'success');
        } else {
            $id = $this->memberManager->insert((array) $values);
            $this->flashMessage('Člen KC byl přidán', 'success');
        }

        $this->redirect('Member:edit', $id);
    }
}
