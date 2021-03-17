<?php
/**
 *
 * Created by PhpStorm.
 * Filename: ArrayFilter.php
 * User: Tomáš Babický
 * Date: 17.03.2021
 * Time: 23:04
 */

namespace App\Filters;

/**
 * Class ArrayFilter
 *
 * @package App\Filters
 */
class ArrayFilter
{
    /**
     * @param array $items
     *
     * @return string
     */
    public function __invoke(array $items) : string
    {
        $concat = '';
        $count = count($items) - 1;
        $i = 0;

        foreach ($items as $item) {
            if ($i !== 0 && $count !== $i) {
                $concat .= ', ';
            }

            if ($count === $i) {
                $concat .= ' a ';
            }

            $concat .= $item;
            $i++;
        }

        return $concat;
    }
}
