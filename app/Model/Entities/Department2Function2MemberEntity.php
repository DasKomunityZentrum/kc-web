<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Department2Function.php
 * User: Tomáš Babický
 * Date: 13.03.2021
 * Time: 2:05
 */

namespace App\Model\Entities;

use Dibi\Row;

/**
 * Class Department2FunctionEntity
 *
 * @package App\Model\Entities
 */
class Department2Function2MemberEntity extends Row
{
    /**
     * @var DepartmentEntity $departmentEntity
     */
    public DepartmentEntity $departmentEntity;

    /**
     * @var FunctionEntity $functionEntity
     */
    public FunctionEntity $functionEntity;

    /**
     * @var MemberEntity $memberEntity
     */
    public MemberEntity $memberEntity;
}
