<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberFilter.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 0:45
 */

namespace App\Filters;

use App\Model\Entities\MemberEntity;

/**
 * Class MemberFilter
 *
 * @package App\Filters
 */
class MemberFilter
{
    /**
     * @param MemberEntity $member
     *
     * @return string
     */
    public function __invoke(MemberEntity $member) : string
    {
        return $member->name . ' ' . $member->surname;
    }
}
