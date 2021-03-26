<?php
/**
 *
 * Created by PhpStorm.
 * Filename: BranchPresenter.php
 * User: Tomáš Babický
 * Date: 13.03.2021
 * Time: 11:46
 */

namespace App\AdminModule\Presenters;

use App\Form\KcForm;
use App\Model\Managers\BranchManager;
use App\Model\Managers\MemberManager;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;

/**
 * Class BranchPresenter
 *
 * @package App\AdminModule\Presenters
 */
class BranchPresenter extends Presenter
{
    /**
     * @var BranchManager $branchManager
     */
    private BranchManager $branchManager;

    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * BranchPresenter constructor.
     *
     * @param BranchManager $branchManager
     * @param MemberManager $memberManager
     */
    public function __construct(
        BranchManager $branchManager,
        MemberManager $memberManager
    ) {
        parent::__construct();

        $this->branchManager = $branchManager;
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
        $branches = $this->branchManager->getAll();

        $this->template->branches = $branches;
        $this->template->branchCount = count($branches);
    }

    /**
     * @param int|null $id
     */
    public function actionEdit(int $id = null) : void
    {
        if ($id) {
            $branch = $this->branchManager->getByPrimaryKey($id);

            if (!$branch) {
                $this->error('Pobočka nenalezena');
            }

            $this['branchForm']->setDefaults($branch);
        }
    }

    /**
     * @param int|null $id
     */
    public function renderEdit(int $id = null) : void
    {
        if ($id) {
            $members = $this->memberManager->getByBranchId($id);
        } else {
            $members = [];
        }

        $this->template->members = $members;
    }

    /**
     * @param int $id
     */
    public function actionDelete(int $id) : void
    {
        $this->branchManager->deleteByPrimaryKey($id);
        $this->flashMessage('Pobočka KC byla smazána', 'success');
        $this->redirect('Branch:default');
    }

    /**
     * @return Form
     */
    public function createComponentBranchForm() : Form
    {
        $form = new KcForm();

        $form->addText('name', 'Jméno');
        $form->addText('city', 'Obec');
        $form->addTextArea('description', 'Popis');

        $form->addSubmit('send', 'Uložit Pobočku KC');

        $form->onSuccess[] = [$this, 'branchFormSuccess'];

        return $form;
    }

    /**
     * @param Form $form
     * @param ArrayHash $values
     */
    public function branchFormSuccess(Form $form, ArrayHash $values) : void
    {
        $id = $this->getParameter('id');

        if ($id) {
            $this->branchManager->updateByPrimaryKey($id, (array) $values);
            $this->flashMessage('Pobočka KC byla aktualizována', 'success');
        } else {
            $id = $this->branchManager->insert((array) $values);
            $this->flashMessage('Pobočka KC byla vytvořena', 'success');
        }

        $this->redirect('Branch:edit', $id);
    }
}
