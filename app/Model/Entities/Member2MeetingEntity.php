<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Member2Meeting.php
 * User: Tomáš Babický
 * Date: 12.03.2021
 * Time: 0:02
 */

namespace App\Model\Entities;

use Dibi\Row;

/**
 * Class Member2MeetingEntity
 *
 * @package App\Model\Entities
 */
class Member2MeetingEntity extends Row
{
    /**
     * @var MemberEntity $memberEntity
     */
    public MemberEntity $memberEntity;

    /**
     * @var MeetingEntity $meetingEntity
     */
    public MeetingEntity $meetingEntity;
}
