<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Department2MemberManager.php
 * User: Tomáš Babický
 * Date: 13.03.2021
 * Time: 2:04
 */

namespace App\Model\Managers;

use App\Model\Entities\Department2Function2MemberEntity;
use App\Model\Tables;
use Dibi\Connection;

/**
 * Class Department2FunctionManager
 *
 * @package App\Model\Managers
 */
class Department2Function2MemberManager extends M2N2OManager
{
    /**
     * Department2Function2MemberManager constructor.
     *
     * @param DepartmentManager $leftTable
     * @param FunctionManager $middleTable
     * @param MemberManager $rightTable
     * @param Connection $dibi
     */
    public function __construct(
        DepartmentManager $leftTable,
        FunctionManager $middleTable,
        MemberManager $rightTable,
        Connection $dibi
    ) {
        parent::__construct($leftTable, $rightTable, $middleTable, $dibi);
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return Tables::DEPARTMENT_2_FUNCTION_2_MEMBER_TABLE;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return Department2Function2MemberEntity::class;
    }
}