<?php
/**
 *
 * Created by PhpStorm.
 * Filename: DepartmentDescriptionFIlter.php
 * User: Tomáš Babický
 * Date: 17.03.2021
 * Time: 14:53
 */

namespace App\FrontModule\Filters;

use App\Model\Entities\DepartmentEntity;

/**
 * Class DepartmentDescriptionFilter
 *
 * @package App\FrontModule\Filters
 */
class DepartmentDescriptionFilter
{
    /**
     * @param DepartmentEntity $departmentEntity
     *
     * @return string
     */
    public function __invoke(DepartmentEntity $departmentEntity) : string
    {
        if ($departmentEntity->description) {
            $descriptions = explode(';', $departmentEntity->description);
            $descriptionCount = count($descriptions) - 1;

            return $descriptions[random_int(0, $descriptionCount)];
        } else {
            return '';
        }
    }
}
