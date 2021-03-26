<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Member2FunctionsFacade.php
 * User: Tomáš Babický
 * Date: 17.03.2021
 * Time: 22:10
 */

namespace App\Model\Facades;

use App\Model\Entities\Member2FunctionEntity;
use App\Model\Entities\MemberEntity;

/**
 * Class Member2Function2Facade
 *
 * @package App\Model\Facades
 */
class Member2FunctionsFacade
{
    /**
     * @var Member2FunctionFacade $member2FunctionFacade
     */
    private Member2FunctionFacade $member2FunctionFacade;

    public function __construct(Member2FunctionFacade $member2FunctionFacade)
    {
        $this->member2FunctionFacade = $member2FunctionFacade;
    }

    /**
     * @param Member2FunctionEntity[] $member2Functions
     *
     * @return MemberEntity[]
     */
    public function join(array $member2Functions) : array
    {
        $members = [];

        foreach ($member2Functions as $member2Function) {
            $member2Function->memberEntity->functions = [];

            $members[$member2Function->memberEntity->id] = $member2Function->memberEntity;
        }

        foreach ($member2Functions as $function) {
            $members[$function->memberEntity->id]->functions[$function->functionEntity->id] = $function->functionEntity;
        }

        return $members;
    }

    public function getByMemberId($memberId)
    {
        $member2Functions = $this->member2FunctionFacade->getByLeft($memberId);

        return $this->join($member2Functions);
    }

    public function getAll()
    {
        $member2Functions = $this->member2FunctionFacade->getAll();

        return $this->join($member2Functions);
    }
}
