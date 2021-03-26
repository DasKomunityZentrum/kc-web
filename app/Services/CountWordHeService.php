<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CountWordHeService.php
 * User: Tomáš Babický
 * Date: 21.03.2021
 * Time: 14:41
 */

namespace App\Services;

/**
 * Class CountWordHeService
 *
 * @package App\Services
 */
class CountWordHeService extends CountWordService
{
    /**
     * @param int $count
     * @param bool $tensDivided
     *
     * @return string
     */
    public function fromZeroToTen(int $count, bool $tensDivided) : string
    {
        if ($tensDivided) {
            return '';
        }

        if ($count === 0) {
            return 'nula';
        } elseif ($count === 1) {
            return 'jeden';
        } elseif ($count === 2) {
            return 'dva';
        } elseif ($count === 3) {
            return 'tři';
        } elseif ($count === 4) {
            return 'čtyři';
        } elseif ($count === 5) {
            return 'pět';
        } elseif ($count === 6) {
            return 'šest';
        } elseif ($count === 7) {
            return 'sedm';
        } elseif ($count === 8) {
            return 'osm';
        } elseif ($count === 9) {
            return 'devět';
        } elseif ($count === 10) {
            return 'deset';
        }
    }
}
