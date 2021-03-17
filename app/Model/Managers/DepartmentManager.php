<?php
/**
 *
 * Created by PhpStorm.
 * Filename: DepartmentManager.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 12:55
 */

namespace App\Model\Managers;

use App\AdminModule\Filters\DepartmentFilter;
use App\Model\Entities\DepartmentEntity;
use App\Model\Tables;
use Dibi\Connection;

/**
 * Class DepartmentManager
 *
 * @package App\Model\Managers
 */
class DepartmentManager extends CrudManager
{
    /**
     * @var DepartmentFilter $departmentFilter
     */
    private DepartmentFilter $departmentFilter;

    /**
     * DepartmentManager constructor.
     *
     * @param Connection $dibi
     * @param DepartmentFilter $departmentFilter
     */
    public function __construct(
        Connection $dibi,
        DepartmentFilter $departmentFilter
    ) {
        parent::__construct($dibi);

        $this->departmentFilter = $departmentFilter;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return Tables::DEPARTMENT_TABLE;
    }

    /**
     * @return string
     */
    public function getEntityClass() : string
    {
        return DepartmentEntity::class;
    }

    public function getPairsForSelect()
    {
        $departments = $this->getAll();
        $memberFilter = $this->departmentFilter;

        $departmentPairs = [];

        foreach ($departments as $department) {
            $departmentPairs[$department->id] = $memberFilter($department);
        }

        return $departmentPairs;
    }
}
