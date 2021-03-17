<?php
/**
 *
 * Created by PhpStorm.
 * Filename: GenderFilter.php
 * User: Tomáš Babický
 * Date: 15.03.2021
 * Time: 1:23
 */

namespace App\FrontModule\Filters;

use App\Model\Entities\MemberEntity;

/**
 * Class GenderFilter
 *
 * @package App\Filters
 */
class GenderFilter
{

    /**
     * @param MemberEntity $memberEntity
     *
     * @return string
     */
    public function __invoke(MemberEntity $memberEntity) : string
    {
        $males = [
            'kluk',
            'chlap',
            'klučina',
            'kluk jak buk',
            'alfa samec',
            'samec',
            'muž',
        ];

        $females = [
            'žena',
            'ženuška',
            'slečna',
            'dáma',
            'dámička',
            'holka',
            'děvče',
            'dívtko',
            'dívka',
            'pohlaví něžného'
        ];

        $maleCount = count($males) - 1;
        $femaleCount = count($females) - 1;

        if ($memberEntity->gender === 'm') {
            return $males[random_int(0, $maleCount)];
        } elseif ($memberEntity->gender === 'f') {
            return $females[random_int(0, $femaleCount)];
        } else {
            return 'neurčitého pohlaví';
        }
    }
}
