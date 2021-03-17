<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Department2FunctionFacade.php
 * User: Tomáš Babický
 * Date: 13.03.2021
 * Time: 2:09
 */

namespace App\Model\Facades;

use App\Model\Entities\Department2Function2MemberEntity;
use App\Model\Entities\Department2FunctionEntity;
use App\Model\Entities\DepartmentEntity;
use App\Model\Entities\FunctionEntity;
use App\Model\Managers\Department2FunctionManager;
use App\Model\Managers\DepartmentManager;
use App\Model\Managers\FunctionManager;

/**
 * Class Department2FunctionFacade
 *
 * @package App\Model\Facades
 */
class Department2FunctionFacade
{
    /**
     * @var DepartmentManager $departmentManager
     */
    private DepartmentManager $departmentManager;

    /**
     * @var Department2FunctionManager $department2FunctionManager
     */
    private Department2FunctionManager $department2FunctionManager;

    /**
     * @var FunctionManager $functionManager
     */
    private FunctionManager $functionManager;

    /**
     * Department2FunctionFacade constructor.
     *
     * @param DepartmentManager $departmentManager
     * @param Department2FunctionManager $department2FunctionManager
     * @param FunctionManager $functionManager
     */
    public function __construct(
        DepartmentManager $departmentManager,
        Department2FunctionManager $department2FunctionManager,
        FunctionManager $functionManager
    ) {
        $this->functionManager = $functionManager;
        $this->departmentManager = $departmentManager;
        $this->department2FunctionManager = $department2FunctionManager;
    }

    /**
     * @param Department2FunctionEntity[] $relations
     * @param DepartmentEntity[] $departments
     * @param FunctionEntity[] $functions
     *
     * @return Department2FunctionEntity[]
     */
    public function join(array $relations, array $departments, array $functions) : array
    {
        foreach ($relations as $relation) {
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

    /**
     * @return Department2FunctionEntity[]
     */
    public function getAll()
    {
        $relations = $this->department2FunctionManager->getAll();
        $departments = $this->departmentManager->getAll();
        $functions = $this->functionManager->getAll();

        return $this->join($relations, $departments, $functions);
    }

    /**
     * @param int $rightId
     *
     * @return Department2FunctionEntity[]
     */
    public function getByRightId(int $rightId)
    {
        $relations = $this->department2FunctionManager->getByRightId($rightId);
        $departments = $this->departmentManager->getAll();
        $function = $this->functionManager->getByPrimaryKey($rightId);

        return $this->join($relations, $departments, [$function]);
    }

    /**
     * @param int $leftId
     *
     * @return Department2Function2MemberEntity[]
     */
    public function getByLeftId(int $leftId)
    {
        $relations = $this->department2FunctionManager->getByLeftId($leftId);
        $department = $this->departmentManager->getByPrimaryKey($leftId);
        $functions = $this->functionManager->getAll();

        return $this->join($relations, [$department], $functions);
    }
}
