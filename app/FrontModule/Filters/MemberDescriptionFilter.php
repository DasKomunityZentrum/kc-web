<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberDescrriptionFilter.php
 * User: Tomáš Babický
 * Date: 17.03.2021
 * Time: 14:33
 */

namespace App\FrontModule\Filters;

use App\Model\Entities\MemberEntity;

/**
 * Class MemberDescriptionFilter
 *
 * @package App\FrontModule\Filters
 */
class MemberDescriptionFilter
{
    /**
     * @param MemberEntity $memberEntity
     *
     * @return string
     */
    public function __invoke(MemberEntity $memberEntity)
    {
        if ($memberEntity->active) {
            if ($memberEntity->description) {
                if ($memberEntity->gender === 'm')  {
                    return 'Co bych vám ještě o sobě pověděl? Už vím. ' . $memberEntity->description;
                } else {
                    return 'Jééjku. Ještě něco o sobě mam říct, jo? Když já nevim... ' . $memberEntity->description;
                }
            } else {
                if ($memberEntity->gender === 'm')  {
                    return 'Co bych vám ještě o sobě pověděl? Nic';
                } else {
                    return 'Jééjku. Ještě něco o sobě mam říct, jo? Jsem moc hezká.';
                }
            }
        } else {
            return 'Zakázali mi o sobě mluvit.';
        }
    }
}
