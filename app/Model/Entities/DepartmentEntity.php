<?php
/**
 *
 * Created by PhpStorm.
 * Filename: DeparmentEntity.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 12:56
 */

namespace App\Model\Entities;

use Dibi\Row;

/**
 * Class DepartmentEntity
 *
 * @package App\Model\Entities
 */
class DepartmentEntity extends Row
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
    public $description;
}
