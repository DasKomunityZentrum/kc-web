<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Department2Functions2MembersFacade.php
 * User: Tomáš Babický
 * Date: 16.03.2021
 * Time: 0:01
 */

namespace App\Model\Facades;

use App\Model\Entities\Department2Function2MemberEntity;
use App\Model\Entities\Department2FunctionEntity;
use App\Model\Entities\DepartmentEntity;
use App\Model\Managers\DepartmentManager;
use App\Model\Managers\FunctionManager;

/**
 * Class Department2Functions2MembersFacade
 *
 * @package App\Model\Facades
 */
class Department2Functions2MembersFacade
{
    /**
     * @var DepartmentManager $departmentManager
     */
    private DepartmentManager $departmentManager;

    /**
     * @var Department2FunctionFacade $department2FunctionFacade
     */
    private Department2FunctionFacade $department2FunctionFacade;

    /**
     * @var FunctionManager $functionManager
     */
    private FunctionManager $functionManager;

    /**
     * @var Departments2Functions2MembersFacade
     */
    private Departments2Functions2MembersFacade $departments2Functions2MembersFacade;

    /**
     * Department2Functions2MembersFacade constructor.
     *
     * @param DepartmentManager $departmentManager
     * @param Department2FunctionFacade $department2FunctionFacade
     * @param FunctionManager $functionManager
     * @param Departments2Functions2MembersFacade $departments2Functions2MembersFacade
     */
    public function __construct(
        DepartmentManager $departmentManager,
        Department2FunctionFacade $department2FunctionFacade,
        FunctionManager $functionManager,
        Departments2Functions2MembersFacade $departments2Functions2MembersFacade,
    ) {
        $this->departmentManager = $departmentManager;
        $this->department2FunctionFacade = $department2FunctionFacade;
        $this->functionManager = $functionManager;
        $this->departments2Functions2MembersFacade = $departments2Functions2MembersFacade;
    }

    /**
     * @param DepartmentEntity[] $departments
     * @param Department2FunctionEntity[] $departments2Functions
     * @param Department2Function2MemberEntity[] $departments2Functions2Members
     *
     * @return DepartmentEntity[]
     */
    public function join(
        array $departments,
        array $departments2Functions,
        array $departments2Functions2Members
    ) {
        $departmentRows = [];

        foreach ($departments as $department) {
            $department->functions = [];

            $departmentRows[$department->id] = $department;
        }

        foreach ($departments2Functions as $departments2Function) {
            $departmentEntity = $departments2Function->departmentEntity;
            $functionEntity = $departments2Function->functionEntity;

            $functionEntity->members = [];

            $departmentRows[$departmentEntity->id]->functions[$functionEntity->id] = clone $functionEntity;
        }

        foreach ($departments2Functions2Members as $i => $departments2Functions2Member) {
            $departmentEntity = $departments2Functions2Member->departmentEntity;
            $functionEntity = $departments2Functions2Member->functionEntity;
            $memberEntity = $departments2Functions2Member->memberEntity;

            $departmentRows[$departmentEntity->id]
                ->functions[$functionEntity->id]
                ->members[$memberEntity->id] = clone $memberEntity;
        }

        return $departments;
    }

    public function getAll() : array
    {
        $departments = $this->departmentManager->getAll();
        $departments2Functions = $this->department2FunctionFacade->getAll();
        $departments2Functions2Members = $this->departments2Functions2MembersFacade->getAll();

        return $this->join($departments, $departments2Functions, $departments2Functions2Members);
    }

    public function getByDepartmentId(int $departmentId)
    {
        $department = $this->departmentManager->getByPrimaryKey($departmentId);
        $departments2Functions = $this->department2FunctionFacade->getByLeftId($departmentId);
        $departments2Functions2Members = $this->departments2Functions2MembersFacade->getByDepartmentId($departmentId);

        return $this->join([$department], $departments2Functions, $departments2Functions2Members)[0];
    }
}
