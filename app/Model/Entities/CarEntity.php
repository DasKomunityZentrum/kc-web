<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CarEntity.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 21:28
 */

namespace App\Model\Entities;

use Dibi\Row;

/**
 * Class CarEntity
 *
 * @package App\Model\Entities
 */
class CarEntity extends Row
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
     * @var int $active
     */
    public int $active;

    /**
     * @var string $nick
     */
    public string $nick;

    /**
     * @var float $ccc
     */
    public float $ccc;

    /**
     * @var int $kw
     */
    public int $kw;

    /**
     * @var string $note
     */
    public string $note;
}
