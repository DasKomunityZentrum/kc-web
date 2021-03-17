<?php
/**
 *
 * Created by PhpStorm.
 * Filename: ActiveFilter.php
 * User: Tomáš Babický
 * Date: 15.03.2021
 * Time: 1:42
 */

namespace App\FrontModule\Filters;

use App\Model\Entities\MemberEntity;

/**
 * Class ActiveFilter
 *
 * @package App\Filters
 */
class ActiveFilter
{
    /**
     * @param MemberEntity $memberEntity
     *
     * @return string
     */
    public function __invoke(MemberEntity $memberEntity) : string
    {
        if ($memberEntity->gender === 'm') {
            if ($memberEntity->active) {
                return 'Jsem platným členem KC.';
            } else {
                return 'Už nejsem platným členem KC.';
            }
        } elseif ($memberEntity->gender === 'f') {
            if ($memberEntity->active) {
                return 'Jsem platnou členkou KC.';
            } else {
                return 'Už nejsem platnou členkou KC.';
            }
        } else {
            if ($memberEntity->active) {
                return 'Jsem platným/platnou členem/členkou KC.';
            } else {
                return 'Už nejsem platným/platnou členem/členkou KC.';
            }
        }
    }
}
