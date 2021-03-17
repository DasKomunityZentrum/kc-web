<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CityFIlter.php
 * User: Tomáš Babický
 * Date: 15.03.2021
 * Time: 2:20
 */

namespace App\FrontModule\Filters;

use App\Model\Entities\MemberEntity;

/**
 * Class CityFilter
 *
 * @package App\FrontModule\Filters
 */
class CityFilter
{
    /**
     * @param MemberEntity $memberEntity
     *
     * @return string
     */
    public function __invoke(MemberEntity $memberEntity) : string
    {
        $branchEntity = $memberEntity->branchEntity;

        if ($branchEntity) {
            $iLiveThere = [
              'tam já bydlím',
              'tady já bydlím',
              'tam já žiju',
              'tady já žiju',
              'odtud pocházím',
              'odsud pocházím',
              'ztama já jsem'
            ];

            $iLiveThereCount = count($iLiveThere) - 1;


            return $branchEntity->city . ', ' . $iLiveThere[random_int(0, $iLiveThereCount)] . '.';
        } else {
            $maleCities = [
                'Nevzpomínám si odkud jsem.',
                'Nevím odkud jsem.',
                'Jsem z ...'
            ];

            $femaleCities = [
                'Do toho odkud jsem ti nic není.',
                'Když bych ti řekla odkud jsem, nedožiješ se rána.'
            ];

            $maleCount = count($maleCities) - 1;
            $femaleCount = count($femaleCities) - 1;

            if ($memberEntity->gender === 'm') {
                return $maleCities[random_int(0, $maleCount)];
            } elseif ($memberEntity->gender === 'f') {
                return $femaleCities[random_int(0, $femaleCount)];
            } else {
                return 'Nevzpomínám si odkud jsem.';
            }
        }
    }
}
