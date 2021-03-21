<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MeetingPresenter.php
 * User: Tomáš Babický
 * Date: 11.03.2021
 * Time: 23:53
 */

namespace App\AdminModule\Presenters;

use App\Form\KcForm;
use App\Model\Facades\MeetingFacade;
use App\Model\Managers\MeetingManager;
use App\Model\Managers\Member2MeetingManager;
use App\Model\Managers\MemberManager;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;

/**
 * Class MeetingPresenter
 *
 * @package App\AdminModule\Presenters
 */
class MeetingPresenter extends Presenter
{
    public static array $meetingTypes = [
        0 => 'V KC',
        1 => 'Výjezdní',
        2 => 'Online'
    ];

    /**
     * @var MeetingFacade $meetingFacade
     */
    private MeetingFacade $meetingFacade;

    /**
     * @var MeetingManager $meetingManager
     */
    private MeetingManager $meetingManager;

    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * @var Member2MeetingManager $member2MeetingManager
     */
    private Member2MeetingManager $member2MeetingManager;

    /**
     * MeetingPresenter constructor.
     *
     * @param MeetingFacade $meetingFacade
     * @param MeetingManager $meetingManager
     * @param Member2MeetingManager $member2MeetingManager
     * @param MemberManager $memberManager
     */
    public function __construct(
        MeetingFacade $meetingFacade,
        MeetingManager $meetingManager,
        Member2MeetingManager $member2MeetingManager,
        MemberManager $memberManager
    ) {
        parent::__construct();

        $this->meetingFacade = $meetingFacade;
        $this->meetingManager = $meetingManager;
        $this->member2MeetingManager = $member2MeetingManager;
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
        $meetings = $this->meetingFacade->getAll();

        $this->template->meetings = $meetings;
        $this->template->meetingCount = count($meetings);
    }

    public function actionEdit(int $id = null)
    {
        $allMembers = $this->memberManager->getPairsForSelect();

        $this['meetingForm-memberId']->setItems($allMembers);

        if ($id) {
            $meeting = $this->meetingManager->getByPrimaryKey($id);
            $selectedMembers = $this->member2MeetingManager->getByRightId($id);

            $selectedMembersAssoc = [];

            foreach ($selectedMembers as $selectedMember) {
                $selectedMembersAssoc[] = $selectedMember->memberId;
            }

            $this['meetingForm']->setDefaults($meeting);
            $this['meetingForm-memberId']->setDefaultValue($selectedMembersAssoc);
        }
    }

    public function renderEdit(int $id = null)
    {

    }

    public function actionDelete(int $id)
    {
        $this->meetingManager->deleteByPrimaryKey($id);
        $this->member2MeetingManager->deleteByRightId($id);
        $this->flashMessage('Zasedání smazáno', 'success');
        $this->redirect('Meeting:default');
    }

    public function createComponentMeetingForm() : Form
    {
        $form = new KcForm();

        $form->addText('name', 'Jméno');
        $form->addTextArea('description', 'Popis');
        $form->addRadioList('type', 'Typ', self::$meetingTypes);
        $form->addCheckbox('isRegular', 'Je pravidelné?');
        $form->addCheckboxList('memberId', 'Přítomní členi');

        $form->addSubmit('send', 'Uložit zasedání');

        $form->onSuccess[] = [$this, 'meetingFormSuccess'];

        return $form;
    }

    public function meetingFormSuccess(Form $form, ArrayHash $values)
    {
        $id = $this->getParameter('id');

        $members = $values->memberId;
        unset($values->memberId);

        if ($id) {
            $this->meetingManager->updateByPrimaryKey($id, (array) $values);
            $this->flashMessage('Zasedání aktualizováno', 'success');
            $this->member2MeetingManager->deleteByRightId($id);
        } else {
            $id = $this->meetingManager->insert((array) $values);
            $this->flashMessage('Zasedání vytvořeno', 'success');
        }

        foreach ($members as $member) {
            $this->member2MeetingManager->insert(
                [
                    'memberId' => $member,
                    'meetingId' => $id
                ]
            );
        }

        $this->redirect('Meeting:edit', $id);
    }
}
