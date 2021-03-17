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

    public int $id;

    public int $memberId;

    public string $description;

    public string $conclusion;

    public MemberEntity $memberEntity;

    public DepartmentEntity $departmentEntity;

}
