<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberTypeFilter.php
 * User: Tomáš Babický
 * Date: 16.03.2021
 * Time: 23:38
 */

namespace App\FrontModule\Filters;

use App\Model\Entities\MemberEntity;

/**
 * Class MemberTypeFilter
 *
 * @package App\FrontModule\Filters
 */
class MemberTypeFilter
{
    /**
     * @param MemberEntity $memberEntity
     *
     * @return string
     */
    public function __invoke(MemberEntity $memberEntity) : string
    {
        if ($memberEntity->type === 0) {
            if ($memberEntity->gender === 'm') {
                return 'Jsem čestným členem KC.';
            } elseif ($memberEntity->gender === 'f') {
                return 'Jsem čestnou členkou KC.';
            }
        } elseif ($memberEntity->type === 1) {
            if ($memberEntity->gender === 'm') {
                return 'Jsem plným členem KC.';
            } elseif ($memberEntity->gender === 'f') {
                return 'Jsem plnou členkou KC.';
            }
        } elseif ($memberEntity->type === 2) {
            if ($memberEntity->gender === 'm') {
                return 'Jsem neplaceným členem KC.';
            } elseif ($memberEntity->gender === 'f') {
                return 'Jsem neplacenou členkou KC.';
            }
        } elseif ($memberEntity->type === 3) {
            if ($memberEntity->gender === 'm') {
                return 'Jsem členem KC ve zkušební době.';
            } elseif ($memberEntity->gender === 'f') {
                return 'Jsem členkou KC ve zkušební době.';
            }
        } elseif ($memberEntity->type === 4) {
            if ($memberEntity->gender === 'm') {
                return 'Už členem KC nejsem.';
            } elseif ($memberEntity->gender === 'f') {
                return 'Jsem členkou KC nejsem.';
            }
        } else {
            return 'Můj typ členství není znám...';
        }
    }
}
