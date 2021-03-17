<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberFunctionPresenter.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 1:33
 */

namespace App\AdminModule\Presenters;

use App\Filters\FunctionFilter;
use App\Filters\MemberFilter;
use App\Form\KCForm;
use App\Model\Facades\Member2FunctionFacade;
use App\Model\Managers\FunctionManager;
use App\Model\Managers\Member2FunctionManager;
use App\Model\Managers\MemberManager;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;

/**
 * Class MemberFunctionPresenter
 *
 * @package App\AdminModule\Presenters
 */
class MemberFunctionPresenter extends Presenter
{
    /**
     * @var FunctionManager $functionManager
     */
    private FunctionManager $functionManager;

    /**
     * @var Member2FunctionManager $member2FunctionManager
     */
    private Member2FunctionManager $member2FunctionManager;

    /**
     * @var Member2FunctionFacade $member2FunctionFacade
     */
    private Member2FunctionFacade $member2FunctionFacade;

    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * Member2FunctionFacade $member2FunctionFacade
     *
     * @param FunctionManager $functionManager
     * @param MemberManager $memberManager
     * @param Member2FunctionManager $member2FunctionManager
     * @param Member2FunctionFacade $member2FunctionFacade
     */
    public function __construct(
        FunctionManager $functionManager,
        MemberManager $memberManager,
        Member2FunctionManager $member2FunctionManager,
        Member2FunctionFacade $member2FunctionFacade,
    ) {
        parent::__construct();

        $this->functionManager = $functionManager;
        $this->memberManager = $memberManager;
        $this->member2FunctionManager = $member2FunctionManager;
        $this->member2FunctionFacade = $member2FunctionFacade;
    }

    public function renderDefault()
    {
        $relations = $this->member2FunctionFacade->getAll();

        $this->template->relations = $relations;
    }

    public function actionEdit(int $memberId = null, int $functionId = null)
    {
        $members = $this->memberManager->getPairsForSelect();
        $functions = $this->functionManager->getPairsForSelect();

        if ($memberId && $functionId) {
            $memberFunction = $this->member2FunctionManager->getByLeftIdAndRightId($memberId, $functionId);

            if (!$memberFunction) {
                $this->error('Členská funkce nenalezena,');
            }
        }

        $this['memberFunctionForm-memberId']->setItems($members)
            ->setDefaultValue($memberId);

        $this['memberFunctionForm-functionId']->setItems($functions)
            ->setDefaultValue($functionId);
    }

    public function actionRender(int $memberId = null, int $functionId = null)
    {

    }

    public function actionDelete(int $memberId, int $functionId)
    {
        $this->member2FunctionManager->deleteByLeftAndRight($memberId, $functionId);
        $this->flashMessage('Členská funkce byla smazána', 'success');
        $this->redirect('MemberFunction:default');
    }

    public function createComponentMemberFunctionForm() : Form
    {
        $form = new KCForm();

        $form->addSelect('memberId', 'Člen KC')
            ->setPrompt('Vyberte člena');

        $form->addSelect('functionId', 'Funkce KC')
            ->setPrompt('Vyberte funkci');

        $form->addSubmit('send', 'Uložit členskou funkci');

        $form->onSuccess[] = [$this, 'memberFunctionFormSuccess'];

        return $form;
    }

    public function memberFunctionFormSuccess(Form $form, ArrayHash $values)
    {
        $memberId = $this->getParameter('memberId');
        $functionId = $this->getParameter('functionId');

        if ($memberId && $functionId) {
            $this->member2FunctionManager->deleteByLeftAndRight($memberId, $functionId);
            $this->member2FunctionManager->insert((array) $values);
            $this->flashMessage('Členská funkce byla aktualizována', 'success');
        } else {
            $memberId = $values->memberId;
            $functionId = $values->functionId;

            $this->member2FunctionManager->insert((array) $values);
            $this->flashMessage('Členská funkce byla přidána', 'success');
        }

        $this->redirect('MemberFunction:edit', $memberId, $functionId);
    }
}
