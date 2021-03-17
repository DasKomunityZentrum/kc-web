<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberCountFIlter.php
 * User: Tomáš Babický
 * Date: 15.03.2021
 * Time: 3:56
 */

namespace App\FrontModule\Filters;

/**
 * Class MemberCountFilter
 *
 * @package App\FrontModule\Filters
 */
class MemberCountFilter
{
    /**
     * @param int $count
     *
     * @return string
     */
    public function fromZeroToTen(int $count) : string
    {
        if ($count === 1) {
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

    /**
     * @param int $count
     *
     * @return string
     */
    public function fromElevenToNineTeen(int $count) : string
    {
        if ($count === 11) {
            return 'jedenáct';
        } elseif ($count === 12) {
            return 'dvanáct';
        } elseif ($count === 13) {
            return 'třináct';
        } elseif ($count === 14) {
            return 'čtrnáct';
        } elseif ($count === 15) {
            return 'patnáct';
        } elseif ($count === 16) {
            return 'šestnáct';
        } elseif ($count === 17) {
            return 'sedmnáct';
        } elseif ($count === 18) {
            return 'osmnáct';
        } elseif ($count === 19) {
            return 'devatenáct';
        }
    }

    /**
     * @param int $count
     *
     * @return string
     */
    public function tens(int $count) : string
    {
        if ($count === 1) {
            return 'deset';
        } elseif ($count === 2) {
            return 'dvacet';
        } elseif ($count === 3) {
            return 'třicet';
        } elseif ($count === 4) {
            return 'čtyřicet';
        } elseif ($count === 5) {
            return 'padesát';
        } elseif ($count === 6) {
            return 'šedesát';
        } elseif ($count === 7) {
            return 'sedmdesát';
        } elseif ($count === 8) {
            return 'osmdesát';
        } elseif ($count === 9) {
            return 'devadesát';
        }
    }

    /**
     * @param int $count
     *
     * @return string
     */
     public function __invoke(int $count) : string
     {
        if ($count > 0 && $count <= 10) {
            return $this->fromZeroToTen($count);
        } elseif ($count >  10 && $count < 20) {
            return  $this->fromElevenToNineTeen($count);
        } elseif ($count > 20 &&  99) {
            $tens = (int)substr((string) $count, 0, 1);
            $units = (int)substr((string) $count, 1, 1);

            return $this->tens($tens) . ' ' . $this->fromZeroToTen($units);
        } else {
            return (string)$count;
        }
    }
}
