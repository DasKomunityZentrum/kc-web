<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Member2FuntionFacade.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 1:39
 */

namespace App\Model\Facades;

use App\Model\Entities\FunctionEntity;
use App\Model\Entities\Member2FunctionEntity;
use App\Model\Entities\MemberEntity;
use App\Model\Managers\FunctionManager;
use App\Model\Managers\Member2FunctionManager;
use App\Model\Managers\MemberManager;

/**
 * Class Member2FunctionFacade
 *
 * @package App\Model\Facades
 */
class Member2FunctionFacade
{
    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * @var FunctionManager $functionManager
     */
    private FunctionManager $functionManager;

    /**
     * @var Member2FunctionManager $member2FunctionManager
     */
    private Member2FunctionManager $member2FunctionManager;

    /**
     * Member2FunctionFacade constructor.
     * @param MemberManager $memberManager
     * @param FunctionManager $functionManager
     * @param Member2FunctionManager $member2FunctionManager
     */
    public function __construct(
        MemberManager $memberManager,
        FunctionManager $functionManager,
        Member2FunctionManager $member2FunctionManager
    ) {
        $this->memberManager = $memberManager;
        $this->functionManager = $functionManager;
        $this->member2FunctionManager = $member2FunctionManager;
    }

    /**
     * @param Member2FunctionEntity[] $relations
     * @param MemberEntity[] $members
     * @param FunctionEntity[] $functions
     *
     * @return Member2FunctionEntity[]
     */
    public function join(array $relations, array $members, array $functions) :array
    {
        foreach ($relations as $relation) {
            foreach ($members as $member) {
                if ($relation->memberId === $member->id) {
                    $relation->memberEntity = $member;

                    break;
                }
            }

            foreach ($functions as $function) {
                if ($relation->functionId === $function->id) {
                    $relation->functionEntity = $function;

                    break;
                }
            }
        }

        return $relations;
    }

    /**
     * @return Member2FunctionEntity[]
     */
    public function getAll() : array
    {
        $relations = $this->member2FunctionManager->getAll();

        $members = $this->memberManager->getAll();
        $functions = $this->functionManager->getAll();

        return $this->join($relations, $members, $functions);
    }

    public function getByRight(int $id)
    {
        $relations = $this->member2FunctionManager->getByRightId($id);
        $members = $this->memberManager->getAll();
        $function = $this->functionManager->getByPrimaryKey($id);

        return $this->join($relations, $members, [$function]);
    }

    public function getByLeft(int $id)
    {
        $relations = $this->member2FunctionManager->getByLeftId($id);
        $member = $this->memberManager->getByPrimaryKey($id);
        $functions = $this->functionManager->getAll();

        return $this->join($relations, [$member], $functions);
    }
}
