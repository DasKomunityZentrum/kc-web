<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MeetingEntity.php
 * User: Tomáš Babický
 * Date: 11.03.2021
 * Time: 23:55
 */

namespace App\Model\Entities;

use Dibi\DateTime;

/**
 * Class MeetingEntity
 *
 * @package App\Model\Entities
 */
class MeetingEntity extends \Dibi\Row
{
    public int $id;

    public string $name;

    public string $description;

    public DateTime $date;

    public int $type;

    public int $isRegular;

}
