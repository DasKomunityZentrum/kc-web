<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MeetingFilter.php
 * User: Tomáš Babický
 * Date: 11.03.2021
 * Time: 23:56
 */

namespace App\AdminModule\Filters;

use App\Model\Entities\MeetingEntity;

/**
 * Class MeetingFilter
 *
 * @package App\Filters
 */
class MeetingFilter
{

    /**
     * @param MeetingEntity $meetingEntity
     * @return string
     */
    public function __invoke(MeetingEntity $meetingEntity) : string
    {
        if ($meetingEntity->isRegular) {
            return $meetingEntity->name . ', od: ' . date_format($meetingEntity->date, 'm.d.Y');
        } else {
            return $meetingEntity->name . ', ' . date_format($meetingEntity->date, 'm.d.Y');
        }
    }
}
