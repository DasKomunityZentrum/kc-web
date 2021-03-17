<?php
/**
 *
 * Created by PhpStorm.
 * Filename: DepartmentFilter.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 12:55
 */

namespace App\AdminModule\Filters;

use App\Model\Entities\DepartmentEntity;

/**
 * Class DepartmentFilter
 *
 * @package App\Filters
 */
class DepartmentFilter
{
    /**
     * @param DepartmentEntity $departmentEntity
     *
     * @return string
     */
    public function __invoke(DepartmentEntity $departmentEntity) : string
    {
        return $departmentEntity->name;
    }
}
