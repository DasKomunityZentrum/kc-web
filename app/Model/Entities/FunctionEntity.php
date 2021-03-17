<?php
/**
 *
 * Created by PhpStorm.
 * Filename: FunctionEntity.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 1:43
 */

namespace App\Model\Entities;

use Dibi\Row;

/**
 * Class FunctionEntity
 *
 * @package App\Model\Entities
 */
class FunctionEntity extends Row
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
     * @var string string
     */
    public string $description;
}
