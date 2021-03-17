<?php
/**
 *
 * Created by PhpStorm.
 * Filename: BoolFilter.php
 * User: Tomáš Babický
 * Date: 13.03.2021
 * Time: 14:48
 */

namespace App\Filters;

/**
 * Class BoolFilter
 *
 * @package App\Filters
 */
class BoolFilter
{
    /**
     * @param int $bool
     *
     * @return string
     */
    public function __invoke(int $bool)
    {
        return $bool ? 'Ano' : 'Ne';
    }
}
