<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Department2FunctionManager.php
 * User: Tomáš Babický
 * Date: 16.03.2021
 * Time: 3:59
 */

namespace App\Model\Managers;

use App\Model\Entities\Department2FunctionEntity;
use App\Model\Tables;
use Dibi\Connection;

/**
 * Class Department2FunctionManager
 *
 * @package App\Model\Managers
 */
class Department2FunctionManager extends M2NManager
{
    /**
     * Department2FunctionManager constructor.
     *
     * @param DepartmentManager $leftTable
     * @param FunctionManager $rightTable
     * @param Connection $dibi
     */
    public function __construct(
        DepartmentManager $leftTable,
        FunctionManager $rightTable,
        Connection $dibi
    ) {
        parent::__construct($leftTable, $rightTable, $dibi);
    }

    /**
     * @return string
     */
    public function getTableName() : string
    {
        return Tables::DEPARTMENT_2_FUNCTION_TABLE;
    }

    /**
     * @return string
     */
    public function getEntityClass() : string
    {
        return Department2FunctionEntity::class;
    }
}
