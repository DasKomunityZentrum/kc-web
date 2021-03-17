<?php
/**
 *
 * Created by PhpStorm.
 * Filename: FunctionFIlter.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 0:47
 */

namespace App\AdminModule\Filters;

use App\Model\Entities\FunctionEntity;

/**
 * Class FunctionFilter
 *
 * @package App\Filters
 */
class FunctionFilter
{
    /**
     * @param FunctionEntity $function
     *
     * @return string
     */
    public function __invoke(FunctionEntity $function) : string
    {
        return $function->name;
    }
}
