<?php
/**
 *
 * Created by PhpStorm.
 * Filename: BranchEntity.php
 * User: Tomáš Babický
 * Date: 13.03.2021
 * Time: 11:47
 */

namespace App\Model\Entities;

use Dibi\Row;

/**
 * Class BranchEntity
 *
 * @package App\Model\Entities
 */
class BranchEntity extends Row
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
     * @var string $city
     */
    public string $city;

    /**
     * @var string $description
     */
    public string $description;
}
