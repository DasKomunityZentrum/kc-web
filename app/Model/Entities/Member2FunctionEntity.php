<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Member2FunctionEntity.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 1:43
 */

namespace App\Model\Entities;

use Dibi\Row;

/**
 * Class Member2FunctionEntity
 *
 * @package App\Model\Entities
 */
class Member2FunctionEntity extends Row
{
    /**
     * @var MemberEntity $memberEntity
     */
    public MemberEntity $memberEntity;

    /**
     * @var FunctionEntity $functionEntity
     */
    public FunctionEntity $functionEntity;
}
