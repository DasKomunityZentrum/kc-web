<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CausePresenter.php
 * User: Tomáš Babický
 * Date: 11.03.2021
 * Time: 20:02
 */

namespace App\AdminModule\Presenters;

use App\Form\KcForm;
use App\Model\Facades\CauseFacade;
use App\Model\Managers\CauseManager;
use App\Model\Managers\DepartmentManager;
use App\Model\Managers\MemberManager;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;

/**
 * Class CausePresenter
 *
 * @package App\AdminModule\Presenters
 */
class CausePresenter extends Presenter
{
    /**
     * @var string[] $causeStates
     */
    public static $causeStates = [
        0 => 'Otevřená',
        1 => 'V řešení',
        2 => 'Vyřešeno',
        3 => 'Odloženo'
    ];

    /**
     * @var CauseFacade $causeFacade
     */
    private CauseFacade $causeFacade;

    /**
     * @var CauseManager $causeManager
     */
    private CauseManager $causeManager;

    /**
     * @var DepartmentManager $departmentManager
     */
    private DepartmentManager $departmentManager;

    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * CausePresenter constructor.
     *
     * @param CauseManager $causeManager
     * @param CauseFacade $causeFacade
     * @param DepartmentManager $departmentManager
     * @param MemberManager $memberManager
     */
    public function __construct(
        CauseManager $causeManager,
        CauseFacade $causeFacade,
        DepartmentManager $departmentManager,
        MemberManager $memberManager
    ) {
        parent::__construct();

        $this->causeFacade = $causeFacade;
        $this->causeManager = $causeManager;
        $this->departmentManager = $departmentManager;
        $this->memberManager = $memberManager;
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
        $causes = $this->causeFacade->getAll();

        $this->template->causes = $causes;
    }

    public function actionEdit(int $id = null)
    {
        $members = $this->memberManager->getPairsForSelect();
        $departments = $this->departmentManager->getPairsForSelect();

        $this['causeForm-memberId']->setItems($members);
        $this['causeForm-departmentId']->setItems($departments);

        if ($id) {
            $cause = $this->causeManager->getByPrimaryKey($id);

            if (!$cause) {
                $this->error('Kauza KC nenalezena');
            }

            $this['causeForm']->setDefaults($cause);
        }
    }

    public function renderEdit(int $id = null)
    {

    }

    public function actionDelete(int $id)
    {
        $this->causeManager->deleteByPrimaryKey($id);
        $this->flashMessage('Kauza KC byla smazána', 'success');
        $this->redirect('Cause:default');
    }

    public function createComponentCauseForm(): Form
    {
        $form = new KcForm();

        $form->addTextArea('name', 'Jméno');
        $form->addSelect('memberId', 'Pachatel')
            ->setPrompt('Vyberte pachatel')
            ->setRequired('Pachatel je povinný');

        $form->addSelect('departmentId', 'V gesci')
            ->setPrompt('Vyberte oddělení KC')
            ->setRequired('Oddělení KC je povinné');

        $form->addRadioList('state', 'Stav', self::$causeStates)
            ->setRequired('Stav je povinný');

        $form->addTextArea('description', 'Popis');
        $form->addTextArea('conclusion', 'Závěr');

        $form->addSubmit('send', 'Uložit Kauzu KC');

        $form->onSuccess[] = [$this, 'causeFormSuccess'];

        return $form;
    }

    public function causeFormSuccess(Form $form, ArrayHash $values)
    {
        $id = $this->getParameter('id');

        if ($id) {
            $this->causeManager->updateByPrimaryKey($id, (array) $values);
            $this->flashMessage('Kauza KC aktualizována', 'success');
        } else {
            $id = $this->causeManager->insert((array) $values);
            $this->flashMessage('Kauza KC vytvořena', 'success');
        }

        $this->redirect('Cause:edit', $id);
    }
}
