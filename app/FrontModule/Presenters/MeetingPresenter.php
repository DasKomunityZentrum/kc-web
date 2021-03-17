<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MeetingPresenter.php
 * User: Tomáš Babický
 * Date: 16.03.2021
 * Time: 2:27
 */

namespace App\FrontModule\Presenters;

use App\Model\Facades\MeetingFacade;
use Nette\Application\UI\Presenter;

/**
 * Class MeetingPresenter
 *
 * @package App\FrontModule\Presenters
 */
class MeetingPresenter extends Presenter
{
    /**
     * @var MeetingFacade $meetingFacade
     */
    private MeetingFacade $meetingFacade;

    /**
     * MeetingPresenter constructor.
     *
     * @param MeetingFacade $meetingFacade
     */
    public function __construct(MeetingFacade $meetingFacade)
    {
        parent::__construct();

        $this->meetingFacade = $meetingFacade;
    }

    public function renderDefault()
    {
        $meetings = $this->meetingFacade->getAll();

        $this->template->meetings = $meetings;
        $this->template->meetingCount = count($meetings);
        $this->template->types = \App\AdminModule\Presenters\MeetingPresenter::$meetingTypes;
    }
}
