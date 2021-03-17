<?php
/**
 *
 * Created by PhpStorm.
 * Filename: ${FILE_NAME}
 * User: Tomáš Babický
 * Date: 12.03.2021
 * Time: 0:08
 */

namespace App\Model\Managers;

use App\Model\Entities\Member2MeetingEntity;
use App\Model\Tables;
use Dibi\Connection;

/**
 * Class Member2MeetingManager
 *
 * @package App\Model\Managers
 */
class Member2MeetingManager extends M2NManager
{
    /**
     * Member2MeetingManager constructor.
     * @param MemberManager $leftTable
     * @param MeetingManager $rightTable
     * @param Connection $dibi
     */
    public function __construct(
        MemberManager $leftTable,
        MeetingManager $rightTable,
        Connection $dibi
    ) {
        parent::__construct($leftTable, $rightTable, $dibi);
    }

    /**
     * @return string
     */
    public function getTableName() : string
    {
        return Tables::MEMBER_2_MEETING_TABLE;
    }

    /**
     * @return string
     */
    public function getEntityClass() : string
    {
        return Member2MeetingEntity::class;
    }
}
