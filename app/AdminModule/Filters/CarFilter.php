<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CarFilter.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 21:29
 */

namespace App\AdminModule\Filters;

use App\Model\Entities\CarEntity;

/**
 * Class CarFilter
 *
 * @package App\Filters
 */
class CarFilter
{
    /**
     * @param CarEntity $carEntity
     *
     * @return string
     */
    public function __invoke(CarEntity $carEntity) : string
    {
        return $carEntity->name . ' ' . $carEntity->ccc . ' ' . $carEntity->kw . ' KW';
    }
}
