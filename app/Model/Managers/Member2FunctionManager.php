<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Member2FunctionManager.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 1:06
 */

namespace App\Model\Managers;

use App\Model\Entities\Member2FunctionEntity;
use App\Model\Tables;
use Dibi\Connection;

/**
 * Class Member2FunctionManager
 *
 * @package App\Managers
 */
class Member2FunctionManager extends M2NManager
{
    public function __construct(
        MemberManager $leftTable,
        FunctionManager $rightTable,
        Connection $dibi
    )  {
        parent::__construct($leftTable, $rightTable, $dibi);
    }

    /**
     * @return string
     */
    public function getTableName() : string
    {
        return Tables::MEMBERS_2_FUNCTIONS_TABLE;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return Member2FunctionEntity::class;
    }
}
