<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Member2Departments2FunctionsFacade.php
 * User: Tomáš Babický
 * Date: 13.03.2021
 * Time: 2:43
 */

namespace App\Model\Facades;

use App\Model\Entities\Department2Function2MemberEntity;
use App\Model\Entities\Department2FunctionEntity;
use App\Model\Entities\DepartmentEntity;
use App\Model\Entities\MemberEntity;
use App\Model\Managers\MemberManager;

/**
 * Class Member2Departments2FunctionsFacade
 *
 * @package App\Model\Facades
 */
class Member2Departments2FunctionsFacade
{
    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * @var Departments2Functions2MembersFacade $departments2Functions2MembersFacade
     */
    private Departments2Functions2MembersFacade $departments2Functions2MembersFacade;

    /**
     * Member2Department2FunctionFacade constructor.
     *
     * @param Departments2Functions2MembersFacade $departments2Functions2MembersFacade
     * @param MemberManager $memberManager
     */
    public function __construct(
        Departments2Functions2MembersFacade $departments2Functions2MembersFacade,
        MemberManager $memberManager
    ) {
        $this->departments2Functions2MembersFacade = $departments2Functions2MembersFacade;
        $this->memberManager = $memberManager;
    }

    /**
     * @param MemberEntity[] $members
     * @param Department2Function2MemberEntity[] $departments2Functions2Members
     *
     * @return MemberEntity[]
     */
    public function join(array $members, array $departments2Functions2Members) : array
    {
        $memberRows = [];

        foreach ($members as $member) {
            $member->departments = [];

            $memberRows[$member->id] = $member;
        }

        foreach ($departments2Functions2Members as $i => $departments2Functions2Member) {
            $departmentEntity = $departments2Functions2Member->departmentEntity;
            $memberEntity = $departments2Functions2Member->memberEntity;

            $memberRows[$memberEntity->id]->departments[$departmentEntity->id] = $departmentEntity;
            $memberRows[$memberEntity->id]->departments[$departmentEntity->id]->functions = [];
        }

        foreach ($departments2Functions2Members as $i => $departments2Functions2Member) {
            $departmentEntity = $departments2Functions2Member->departmentEntity;
            $functionEntity = $departments2Functions2Member->functionEntity;
            $memberEntity = $departments2Functions2Member->memberEntity;

            $memberRows[$memberEntity->id]
                ->departments[$departmentEntity->id]
                ->functions[$functionEntity->id] = clone $functionEntity;
        }

        return $members;
    }

    /**
     * @param int $memberId
     *
     * @return MemberEntity
     */
    public function getByMemberId(int $memberId) : MemberEntity
    {
        $member = $this->memberManager->getByPrimaryKey($memberId);
        $departments2Functions2Members = $this->departments2Functions2MembersFacade->getByMemberId($memberId);

        return $this->join([$member],$departments2Functions2Members)[0];
    }

    /**
     * @return MemberEntity[]
     */
    public function getAll() : array
    {
        $members = $this->memberManager->getAll();
        $departments2Functions2Members = $this->departments2Functions2MembersFacade->getAll();

        return $this->join($members, $departments2Functions2Members);
    }
}
