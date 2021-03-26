<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MeetingFacade.php
 * User: Tomáš Babický
 * Date: 12.03.2021
 * Time: 0:05
 */

namespace App\Model\Facades;

use App\Model\Managers\MeetingManager;
use App\Model\Managers\Member2MeetingManager;
use App\Model\Managers\MemberManager;

/**
 * Class MeetingFacade
 *
 * @package App\Model\Facades
 */
class MeetingFacade
{
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
     * MeetingFacade constructor.
     *
     * @param MeetingManager $meetingManager
     * @param MemberManager $memberManager
     * @param Member2MeetingManager $member2MeetingManager
     */
    public function __construct(
        MeetingManager $meetingManager,
        MemberManager $memberManager,
        Member2MeetingManager $member2MeetingManager
    ) {
        $this->meetingManager = $meetingManager;
        $this->member2MeetingManager = $member2MeetingManager;
        $this->memberManager = $memberManager;
    }

    public function join(array $relations, array $meetings, $members) : array
    {
        $meetingMembers = [];

        foreach ($relations as $relation) {
            foreach ($members as $member) {
                if ($relation->memberId === $member->id) {
                    $meetingMembers[$relation->meetingId][] = $member;
                    break;
                }
            }
        }

        foreach ($meetings as $meeting) {
            if (isset($meetingMembers[$meeting->id])) {
                $meeting->members = $meetingMembers[$meeting->id];
            } else {
                $meeting->members = [];
            }
        }

        return $meetings;
    }

    public function getAll() : array
    {
        $meetings = $this->meetingManager->getAll();
        $members = $this->memberManager->getAll();
        $relations = $this->member2MeetingManager->getAll();

        return $this->join($relations, $meetings, $members);
    }
}
