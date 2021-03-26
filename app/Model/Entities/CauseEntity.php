<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CaseEntity.php
 * User: Tomáš Babický
 * Date: 11.03.2021
 * Time: 20:07
 */

namespace App\Model\Entities;

use Dibi\Row;

/**
 * Class CaseEntity
 *
 * @package App\Model\Entities
 */
class CauseEntity extends Row
{
    /**
     * @var int  $id
     */
    public int $id;

    /**
     * @var int $memberId
     */
    public int $memberId;

    /**
     * @var string $name
     */
    public string $name;

    /**
     * @var string $description
     */
    public string $description;

    /**
     * @var string $conclusion
     */
    public string $conclusion;

    /**
     * @var MemberEntity $memberEntity
     */
    public MemberEntity $memberEntity;

    /**
     * @var DepartmentEntity $departmentEntity
     */
    public DepartmentEntity $departmentEntity;
}
