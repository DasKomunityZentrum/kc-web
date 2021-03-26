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
use App\Model\Facades\Departments2Functions2MembersFacade;
use App\Model\Managers\Department2Function2MemberManager;
use App\Model\Managers\Department2FunctionManager;
use App\Model\Managers\DepartmentManager;
use App\Model\Managers\FunctionManager;
use App\Model\Managers\MemberManager;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;

/**
 * Class DepartmentFunctionMemberPresenter
 *
 * @package App\AdminModule\Presenters
 */
class DepartmentFunctionMemberPresenter extends Presenter
{
    /**
     * @var DepartmentManager $departmentManager
     */
    private DepartmentManager $departmentManager;

    /**
     * @var Department2FunctionManager $department2FunctionManager
     */
    private Department2FunctionManager $department2FunctionManager;

    /**
     * @var Departments2Functions2MembersFacade $departments2Functions2MembersFacade
     */
    private Departments2Functions2MembersFacade $departments2Functions2MembersFacade;

    /**
     * @var Department2Function2MemberManager $department2Function2MemberManager
     */
    private Department2Function2MemberManager $department2Function2MemberManager;

    /**
     * @var FunctionManager $functionManager
     */
    private FunctionManager $functionManager;

    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * DepartmentFunctionMemberPresenter constructor.
     *
     * @param Departments2Functions2MembersFacade $departments2Functions2MembersFacade
     * @param Department2Function2MemberManager $department2Function2MemberManager
     * @param Department2FunctionManager $department2FunctionManager
     * @param DepartmentManager $departmentManager
     * @param FunctionManager $functionManager
     * @param MemberManager $memberManager
     */
    public function __construct(
        Departments2Functions2MembersFacade $departments2Functions2MembersFacade,
        Department2Function2MemberManager $department2Function2MemberManager,
        Department2FunctionManager $department2FunctionManager,
        DepartmentManager $departmentManager,
        FunctionManager $functionManager,
        MemberManager $memberManager
    ) {
        parent::__construct();

        $this->departmentManager = $departmentManager;
        $this->department2FunctionManager = $department2FunctionManager;
        $this->departments2Functions2MembersFacade = $departments2Functions2MembersFacade;
        $this->department2Function2MemberManager = $department2Function2MemberManager;
        $this->functionManager = $functionManager;
        $this->memberManager = $memberManager;
    }

    public function startup() : void
    {
        parent::startup();

        if (!$this->user->loggedIn) {
            $this->flashMessage('Nejste přihlášený', 'warning');
            $this->redirect('Login:default');
        }
    }

    public function renderDefault() : void
    {
        $relations = $this->departments2Functions2MembersFacade->getAll();

        $this->template->relations = $relations;
        $this->template->departmentFunctionMemberCount = count($relations);
    }

    /**
     * @param int|null $departmentId
     * @param int|null $functionId
     * @param int|null $memberId
     */
    public function actionEdit(int $departmentId = null, int $functionId = null, int $memberId = null) : void
    {
        $departments = $this->departmentManager->getPairsForSelect();
        $functions = $this->functionManager->getPairsForSelect();
        $members = $this->memberManager->getPairsForSelect();

        if ($departmentId && $functionId) {
            $departmentFunction = $this->department2Function2MemberManager->getByLeftIdAndMiddleIdAndRightId(
                $departmentId,
                $functionId,
                $memberId
            );

            if (!$departmentFunction) {
                $this->error('Členská Funkce Oddělení KC nebyla nalezena');
            }
        }

        $this['departmentFunctionForm-departmentId']->setItems($departments)
            ->setDefaultValue($departmentId);

        $this['departmentFunctionForm-functionId']->setItems($functions)
            ->setDefaultValue($functionId);

        $this['departmentFunctionForm-memberId']->setItems($members)
            ->setDefaultValue($memberId);
    }

    /**
     * @param int|null $departmentId
     * @param int|null $functionId
     */
    public function actionRender(int $departmentId = null, int $functionId = null) : void
    {
    }

    /**
     * @param int $departmentId
     * @param int $functionId
     * @param int $memberId
     */
    public function actionDelete(int $departmentId, int $functionId, int $memberId) : void
    {
        $this->department2Function2MemberManager->deleteByLeftAnMidlleAnddRight($departmentId, $functionId, $memberId);
        $this->flashMessage('Členská Funkce Oddělení KC byla smazána', 'success');
        $this->redirect('DepartmentFunctionMember:default');
    }

    /**
     * @return Form
     */
    public function createComponentDepartmentFunctionForm() : Form
    {
        $form = new KcForm();

        $form->addSelect('departmentId', 'Oddělení KC')
            ->setPrompt('Vyberte oddělení KC');

        $form->addSelect('functionId', 'Funkce KC')
            ->setPrompt('Vyberte funkci KC');

        $form->addSelect('memberId', 'Člen KC')
            ->setPrompt('Vyberte člena KC');

        $form->addSubmit('send', 'Uložit Členskou Funkci Oddělení KC');

        $form->onSuccess[] = [$this, 'departmentFunctionFormSuccess'];

        return $form;
    }

    /**
     * @param Form $form
     * @param ArrayHash $values
     */
    public function departmentFunctionFormSuccess(Form $form, ArrayHash $values) : void
    {
        $departmentId = $this->getParameter('departmentId');
        $functionId = $this->getParameter('functionId');
        $memberId = $this->getParameter('memberId');

        if ($departmentId && $functionId) {
            $this->department2Function2MemberManager->deleteByLeftAnMidlleAnddRight($departmentId, $functionId, $memberId);
            $this->department2Function2MemberManager->insert((array) $values);
            $this->flashMessage('Členská Funkce Oddělení KC byla aktualizována', 'success');
        } else {
            $departmentId = $values->departmentId;
            $functionId = $values->functionId;
            $memberId = $values->memberId;

            $exists = $this->department2FunctionManager->getByLeftIdAndRightId($departmentId, $functionId);

            if (!$exists) {
                $this->department2FunctionManager->insert(
                    [
                        'departmentId' => $departmentId,
                        'functionId' => $functionId
                    ]
                );
            }

            $this->department2Function2MemberManager->insert((array) $values);
            $this->flashMessage('Členská Funkce Oddělení KC byla přidána', 'success');
        }

        $this->redirect('DepartmentFunctionMember:edit', $departmentId, $functionId, $memberId);
    }
}
