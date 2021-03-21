<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CountWordSheService.php
 * User: Tomáš Babický
 * Date: 21.03.2021
 * Time: 14:41
 */

namespace App\Services;

/**
 * Class CountWordSheService
 *
 * @package App\Services
 */
class CountWordSheService extends CountWordService
{
    /**
     * @param int $count
     *
     * @return string
     */
    public function fromZeroToTen(int $count) : string
    {
        if ($count === 1) {
            return 'jedna';
        } elseif ($count === 2) {
            return 'dvě';
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
