<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Member2MeetingFacade.php
 * User: Tomáš Babický
 * Date: 12.03.2021
 * Time: 1:38
 */

namespace App\Model\Facades;

use App\Model\Managers\MeetingManager;
use App\Model\Managers\Member2MeetingManager;
use App\Model\Managers\MemberManager;

/**
 * Class Member2MeetingFacade
 *
 * @package App\Model\Facades
 */
class Member2MeetingFacade
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

    public function join(array $relations, array $meetings, $members)
    {
        foreach ($relations as $relation) {
            foreach ($meetings as $meeting) {
                if ($relation->meetingId === $meeting->id) {
                    $relation->meetingEntity = $meeting;

                    break;
                }
            }

            foreach ($members as $member) {
                if ($relation->memberId === $member->id) {
                    $relation->memberEntity = $member;

                    break;
                }
            }
        }

        return $relations;
    }

    public function getByRightId($rightId) : array
    {
        $relations = $this->member2MeetingManager->getByRightId($rightId);
        $members = $this->memberManager->getAll();
        $meeting = $this->meetingManager->getByPrimaryKey($rightId);

        return $this->join($relations, [$meeting], $members);
    }

    public function getByLeftId($leftId) : array
    {
        $relations = $this->member2MeetingManager->getByLeftId($leftId);
        $member = $this->memberManager->getByPrimaryKey($leftId);
        $meetings = $this->meetingManager->getAll();

        return $this->join($relations, $meetings, [$member]);
    }
}