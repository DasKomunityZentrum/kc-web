<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberEntity.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 1:43
 */

namespace App\Model\Entities;

use Dibi\Row;

/**
 * Class MemberEntity
 *
 * @package App\Model\Entities
 */
class MemberEntity extends Row
{
    /**
     * MemberEntity constructor.
     *
     * @param array $arr
     */
    public function __construct(array $arr)
    {
        parent::__construct($arr);

        $this->branchEntity = null;
        $this->carEntity = null;
    }
    /**
     * @var int $id
     */
    public int $id;

    /**
     * @var string $name
     */
    public string $name;

    /**
     * @var string $surname
     */
    public string $surname;

    /**
     * @var ?string $nick
     */
    public ?string $nick;

    /**
     * @var string $gender
     */
    public string $gender;

    /**
     * @var ?int $birthYear
     */
    public ?int $birthYear;

    /**
     * @var string $description
     */
    public string $description;

    /**
     * @var int $active
     */
    public int $active;

    /**
     * @var int $type
     */
    public int $type;

    /**
     * @var int $carId
     */
    public ?int $carId;

    /**
     * @var ?CarEntity $carEntity
     */
    public ?CarEntity $carEntity;

    /**
     * @var ?int $branchId
     */
    public ?int $branchId;

    /**
     * @var ?BranchEntity $branchEntity
     */
    public ?BranchEntity $branchEntity;

    /**
     * @var ?string $profilePhoto
     */
    public ?string $profilePhoto;

    /**
     * @var ?string $profilePhotoExtension
     */
    public ?string $profilePhotoExtension;
}
