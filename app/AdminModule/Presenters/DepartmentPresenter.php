<?php
/**
 *
 * Created by PhpStorm.
 * Filename: DepartmentPresenter.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 13:00
 */

namespace App\AdminModule\Presenters;

use App\Form\KcForm;
use App\Model\Facades\Department2FunctionFacade;
use App\Model\Facades\Department2Functions2MembersFacade;
use App\Model\Managers\DepartmentManager;
use JetBrains\PhpStorm\NoReturn;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;

/**
 * Class DepartmentPresenter
 *
 * @package App\AdminModule\Presenters
 */
class DepartmentPresenter extends Presenter
{
    /**
     * @var DepartmentManager $departmentManager
     */
    private DepartmentManager $departmentManager;

    /**
     * @var Department2FunctionFacade $department2FunctionFacade
     */
    private Department2FunctionFacade $department2FunctionFacade;

    /**
     * @var Department2Functions2MembersFacade $department2Functions2MembersFacade
     */
    private Department2Functions2MembersFacade $department2Functions2MembersFacade;

    /**
     * DepartmentPresenter constructor.
     *
     * @param DepartmentManager $departmentManager
     * @param Department2FunctionFacade $department2FunctionFacade
     * @param Department2Functions2MembersFacade $department2Functions2MembersFacade
     */
    public function __construct(
        DepartmentManager $departmentManager,
        Department2FunctionFacade $department2FunctionFacade,
        Department2Functions2MembersFacade $department2Functions2MembersFacade
    ) {
        parent::__construct();

        $this->departmentManager = $departmentManager;
        $this->department2FunctionFacade = $department2FunctionFacade;
        $this->department2Functions2MembersFacade = $department2Functions2MembersFacade;
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
        $departments = $this->departmentManager->getAll();

        $this->template->departments = $departments;
        $this->template->departmentCount = count($departments);
    }

    /**
     * @param int|null $id
     */
    public function actionEdit(int $id = null) : void
    {
        if ($id) {
            $department = $this->departmentManager->getByPrimaryKey($id);

            if (!$department) {
                $this->error('Oddělení KC nenalezen.');
            }

            $this['departmentForm']->setDefaults($department);
        }
    }

    /**
     * @param int|null $id
     */
    public function renderEdit(int $id = null) : void
    {
        if ($id) {
            $functions = $this->department2FunctionFacade->getByLeftId($id);
            $functions2Members = $this->department2Functions2MembersFacade->getByDepartmentId($id)->functions;
        } else {
            $functions = [];
            $functions2Members = [];
        }

        $this->template->functions = $functions;
        $this->template->functions2Members = $functions2Members;
    }

    #[NoReturn]
    public function actionDelete(int $id = null) : void
    {
        $this->departmentManager->deleteByPrimaryKey($id);
        $this->flashMessage('Oddělení KC bylo smazán.', 'success');
        $this->redirect('Department:default');
    }

    /**
     * @return Form
     */
    public function createComponentDepartmentForm() : Form
    {
        $form = new KcForm();

        $form->addText('name', 'Jméno');
        $form->addTextArea('description', 'Popis');
        $form->addCheckbox('onStrike', 'Ve stávce');

        $form->addSubmit('send', 'Uložit Oddělení KC');

        $form->onSuccess[] = [$this, 'departmentFormSuccess'];

        return $form;
    }

    /**
     * @param Form $form
     * @param ArrayHash $values
     */
    public function departmentFormSuccess(Form $form, ArrayHash $values) : void
    {
        $id = $this->getParameter('id');

        if ($id) {
            $this->departmentManager->updateByPrimaryKey($id, (array) $values);
            $this->flashMessage('Oddělení KC bylo aktualizováno', 'success');
        } else {
            $id = $this->departmentManager->insert((array) $values);
            $this->flashMessage('Oddělení KC bylo vytvořeno', 'success');
        }

        $this->redirect('Department:edit', $id);
    }
}
