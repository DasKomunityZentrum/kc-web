<?php
/**
 *
 * Created by PhpStorm.
 * Filename: FunctionPresenter.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 1:09
 */

namespace App\AdminModule\Presenters;

use App\Form\KCForm;
use App\Model\Facades\Department2FunctionFacade;
use App\Model\Facades\Member2FunctionFacade;
use App\Model\Managers\FunctionManager;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;

/**
 * Class FunctionPresenter
 *
 * @package App\AdminModule\Presenters
 */
class FunctionPresenter extends Presenter
{
    public static $functionTypes = [
       0 => 'Běžná',
       1 => 'Čestná',
       2 => 'Placená',
       3 => 'Neplacená'
    ] ;

    /**
     * @var FunctionManager $functionManager
     */
    private FunctionManager $functionManager;

    /**
     * @var Member2FunctionFacade $member2FunctionFacade
     */
    private Member2FunctionFacade $member2FunctionFacade;

    /**
     * @var Department2FunctionFacade $department2FunctionFacade
     */
    private Department2FunctionFacade $department2FunctionFacade;

    /**
     * FunctionPresenter constructor.
     *
     * @param FunctionManager $functionManager
     * @param Member2FunctionFacade $member2FunctionFacade
     */
    public function __construct(
        Department2FunctionFacade $department2FunctionFacade,
        FunctionManager $functionManager,
        Member2FunctionFacade $member2FunctionFacade
    ) {
        parent::__construct();

        $this->department2FunctionFacade = $department2FunctionFacade;
        $this->functionManager = $functionManager;
        $this->member2FunctionFacade = $member2FunctionFacade;
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
        $functions = $this->functionManager->getAll();

        $this->template->functions = $functions;
    }

    /**
     * @param int|null $id
     */
    public function actionEdit(int $id = null)
    {
        if ($id) {
            $function = $this->functionManager->getByPrimaryKey($id);

            if (!$function) {
                $this->error('Funkce nenalezena.');
            }

            $this['functionForm']->setDefaults($function);
        }
    }

    /**
     * @param int|null $id
     */
    public function renderEdit(int $id = null)
    {
        if ($id) {
            $members = $this->member2FunctionFacade->getByRight($id);
            $departments = $this->department2FunctionFacade->getByRightId($id);
        } else {
            $members = [];
            $departments = [];
        }


        $this->template->members = $members;
        $this->template->departments = $departments;
    }

    public function actionDelete(int $id)
    {
        $this->functionManager->deleteByPrimaryKey($id);
        $this->flashMessage('Funkce byla smazána', 'success');
        $this->redirect('Function:default');
    }

    public function createComponentFunctionForm() : Form
    {
        $form = new KCForm();

        $form->addText('name', 'Jméno')
            ->setRequired('Jméno je povinné');

        $form->addRadioList('type', 'Typ', self::$functionTypes)
            ->setRequired('Type je povinný');

        $form->addTextArea('description', 'Popisek');

        $form->addSubmit('send','Uložit funkci');

        $form->onSuccess[] = [$this, 'functionFormSuccess'];

        return $form;
    }

    public function functionFormSuccess(Form $form, ArrayHash $values)
    {
        $id = $this->getParameter('id');

        if ($id) {
            $this->functionManager->updateByPrimaryKey($id, (array) $values);
            $this->flashMessage('Funkce byla aktualizována', 'success');
        } else {
            $id = $this->functionManager->insert((array) $values);
            $this->flashMessage('Funkce byla přidána', 'success');
        }

        $this->redirect('Function:edit', $id);
    }
}
