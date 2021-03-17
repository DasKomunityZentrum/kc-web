<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MeetingFilter.php
 * User: Tomáš Babický
 * Date: 16.03.2021
 * Time: 2:37
 */

namespace App\FrontModule\Filters;

use App\Model\Entities\MeetingEntity;

/**
 * Class MeetingFilter
 *
 * @package App\FrontModule\Filters
 */
class MeetingFilter
{
    /**
     * @param MeetingEntity $meetingEntity
     *
     * @return string
     */
    public function __invoke(MeetingEntity $meetingEntity) : string
    {
        return $meetingEntity->name;
    }
}
