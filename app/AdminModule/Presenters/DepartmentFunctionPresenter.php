<?php
/**
 *
 * Created by PhpStorm.
 * Filename: DepartmentFunctionMemberPresenter.php
 * User: Tomáš Babický
 * Date: 13.03.2021
 * Time: 2:01
 */

namespace App\AdminModule\Presenters;

use App\Form\KcForm;
use App\Model\Facades\Department2FunctionFacade;
use App\Model\Managers\Department2FunctionManager;
use App\Model\Managers\DepartmentManager;
use App\Model\Managers\FunctionManager;
use App\Model\Managers\MemberManager;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

/**
 * Class DepartmentFunctionPresenter
 *
 * @package App\AdminModule\Presenters
 */
class DepartmentFunctionPresenter extends \Nette\Application\UI\Presenter
{
    /**
     * @var Department2FunctionFacade $departments2FunctionsFacade
     */
    private Department2FunctionFacade $department2FunctionFacade;

    /**
     * @var Department2FunctionManager $department2FunctionManager
     */
    private Department2FunctionManager $department2FunctionManager;

    /**
     * @var FunctionManager $functionManager
     */
    private FunctionManager $functionManager;

    /**
     * @var DepartmentManager $departmentManager
     */
    private DepartmentManager $departmentManager;

    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * DepartmentFunctionMemberPresenter constructor.
     *
     * @param Department2FunctionFacade $department2FunctionFacade
     * @param Department2FunctionManager $department2FunctionManager
     * @param DepartmentManager $departmentManager
     * @param FunctionManager $functionManager
     * @param MemberManager $memberManager
     */
    public function __construct(
        Department2FunctionFacade $department2FunctionFacade,
        Department2FunctionManager $department2FunctionManager,
        DepartmentManager $departmentManager,
        FunctionManager $functionManager,
        MemberManager $memberManager
    ) {
        parent::__construct();

        $this->department2FunctionFacade = $department2FunctionFacade;
        $this->department2FunctionManager = $department2FunctionManager;
        $this->departmentManager = $departmentManager;
        $this->functionManager = $functionManager;
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
        $relations = $this->department2FunctionFacade->getAll();

        $this->template->relations = $relations;
        $this->template->departmentFunctionCount = count($relations);
    }

    public function actionEdit(int $departmentId = null, int $functionId = null)
    {
        $departments = $this->departmentManager->getPairsForSelect();
        $functions = $this->functionManager->getPairsForSelect();


        if ($departmentId && $functionId) {
            $departmentFunction = $this->department2FunctionManager->getByLeftIdAndRightId($departmentId, $functionId);

            if (!$departmentFunction) {
                $this->error('Funkce Oddělení KC nebyla nalezena');
            }
        }

        $this['departmentFunctionForm-departmentId']->setItems($departments)
            ->setDefaultValue($departmentId);

        $this['departmentFunctionForm-functionId']->setItems($functions)
            ->setDefaultValue($functionId);
    }

    /**
     * @param int|null $departmentId
     * @param int|null $functionId
     */
    public function renderEdit(int $departmentId = null, int $functionId = null)
    {
    }

    public function actionDelete(int $departmentId, int $functionId)
    {
        $this->department2FunctionManager->deleteByLeftAndRight($departmentId, $functionId);
        $this->flashMessage('Funkce Oddělení KC byla smazána', 'success');
        $this->redirect('DepartmentFunction:default');
    }

    public function createComponentDepartmentFunctionForm() : Form
    {
        $form = new KcForm();

        $form->addSelect('departmentId', 'Oddělení KC')
            ->setPrompt('Vyberte oddělení KC');

        $form->addSelect('functionId', 'Funkce KC')
            ->setPrompt('Vyberte funkci');

        $form->addSubmit('send', 'Uložit Funkci Oddělení KC');

        $form->onSuccess[] = [$this, 'departmentFunctionFormSuccess'];

        return $form;
    }

    public function departmentFunctionFormSuccess(Form $form, ArrayHash $values)
    {
        $departmentId = $this->getParameter('departmentId');
        $functionId = $this->getParameter('functionId');

        if ($departmentId && $functionId) {
            $this->department2FunctionManager->deleteByLeftAndRight($departmentId, $functionId);
            $this->department2FunctionManager->insert((array) $values);
            $this->flashMessage('Funkce Oddělení KC byla aktualizována', 'success');
        } else {
            $departmentId = $values->departmentId;
            $functionId = $values->functionId;

            $this->department2FunctionManager->insert((array) $values);
            $this->flashMessage('Funkce Oddělení KC byla přidána', 'success');
        }

        $this->redirect('DepartmentFunction:edit', $departmentId, $functionId);
    }
}