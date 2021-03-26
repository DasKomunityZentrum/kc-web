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
    /**
     * @var int $id
     */
    public int $id;

    /**
     * @var string $name
     */
    public string $name;

    /**
     * @var string $description
     */
    public string $description;

    /**
     * @var DateTime $date
     */
    public DateTime $date;

    /**
     * @var int $type
     */
    public int $type;

    /**
     * @var int $isRegular
     */
    public int $isRegular;
}
