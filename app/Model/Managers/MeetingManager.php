<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MeetingManager.php
 * User: Tomáš Babický
 * Date: 11.03.2021
 * Time: 23:54
 */

namespace App\Model\Managers;

use App\Model\Entities\MeetingEntity;
use App\Model\Tables;

/**
 * Class MeetingManager
 *
 * @package App\Model\Managers
 */
class MeetingManager extends CrudManager
{
    /**
     * @return string
     */
    public function getTableName(): string
    {
        return Tables::MEETING_TABLE;
    }

    /**
     * @return string
     */
    public function getEntityClass() : string
    {
        return MeetingEntity::class;
    }
}
