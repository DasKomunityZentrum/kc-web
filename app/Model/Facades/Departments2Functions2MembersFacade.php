<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Departments2Functions2MembersFacade.php
 * User: Tomáš Babický
 * Date: 16.03.2021
 * Time: 3:18
 */

namespace App\Model\Facades;

use App\Model\Managers\Department2Function2MemberManager;
use App\Model\Managers\DepartmentManager;
use App\Model\Managers\FunctionManager;
use App\Model\Managers\MemberManager;

/**
 * Class Departments2Functions2MembersFacade
 *
 * @package App\Model\Facades
 */
class Departments2Functions2MembersFacade
{

    /**
     * @var DepartmentManager
     */
    private DepartmentManager $departmentManager;

    /**
     * @var Department2Function2MemberManager
     */
    private Department2Function2MemberManager $department2Function2MemberManager;

    /**
     * @var FunctionManager
     */
    private FunctionManager $functionManager;

    /**
     * @var MemberManager
     */
    private MemberManager $memberManager;

    public function __construct(
        DepartmentManager $departmentManager,
        Department2Function2MemberManager $department2Function2MemberManager,
        FunctionManager $functionManager,
        MemberManager $memberManager
    ) {
        $this->departmentManager = $departmentManager;
        $this->department2Function2MemberManager = $department2Function2MemberManager;
        $this->functionManager = $functionManager;
        $this->memberManager = $memberManager;
    }

    public function join (array $relations, array $members, array $departments, array $functions)
    {
        foreach ($relations as $relation) {
            foreach ($members as $member) {
                if ($relation->memberId === $member->id) {
                    $relation->memberEntity = $member;

                    break;
                }
            }

            foreach ($departments as $department) {
                if ($relation->departmentId === $department->id) {
                    $relation->departmentEntity = $department;

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

    public function getAll() : array
    {
        $relations = $this->department2Function2MemberManager->getAll();
        $members = $this->memberManager->getAll();
        $departments = $this->departmentManager->getAll();
        $functions = $this->functionManager->getAll();

        return $this->join($relations, $members, $departments, $functions);
    }

    /**
     * @param int $memberId
     *
     * @return array
     */
    public function getByMemberId(int $memberId) : array
    {
        $relations = $this->department2Function2MemberManager->getByRightId($memberId);
        $member = $this->memberManager->getByPrimaryKey($memberId);
        $departments = $this->departmentManager->getAll();
        $functions = $this->functionManager->getAll();

        return $this->join($relations, [$member], $departments, $functions);
    }

    public function getByDepartmentId(int $departmentId): array
    {
        $relations = $this->department2Function2MemberManager->getByLeftId($departmentId);
        $members = $this->memberManager->getAll();
        $department = $this->departmentManager->getByPrimaryKey($departmentId);
        $functions = $this->functionManager->getAll();

        return $this->join($relations, $members, [$department], $functions);
    }
}
