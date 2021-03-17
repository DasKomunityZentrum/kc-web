<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberManager.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 0:09
 */

namespace App\Model\Managers;

use App\Filters\MemberFilter;
use App\Model\Entities\MemberEntity;
use App\Model\Tables;
use Dibi\Connection;

/**
 * Class MemberManager
 *
 * @package App\Managers
 */
class MemberManager extends CrudManager
{
    /**
     * @var MemberFilter $memberFilter
     */
    private MemberFilter $memberFilter;

    /**
     * MemberManager constructor.
     *
     * @param Connection $dibi
     * @param MemberFilter $memberFilter
     */
    public function __construct(
        Connection $dibi,
        MemberFilter $memberFilter
    ) {
        parent::__construct($dibi);

        $this->memberFilter = $memberFilter;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return Tables::MEMBERS_TABLE;
    }

    /**
     * @return string
     */
    public function getEntityClass() : string
    {
        return MemberEntity::class;
    }

    /**
     * @return array
     */
    public function getPairsForSelect() : array
    {
        $members = $this->getAll();
        $memberFilter = $this->memberFilter;

        $memberPairs = [];

        foreach ($members as $member) {
            $memberPairs[$member->id] = $memberFilter($member);
        }

        return $memberPairs;
    }

    public function getByCarId(int $carId)
    {
        return $this->getAllFluent()
            ->where('[carId] = %i', $carId)
            ->execute()
            ->setRowClass($this->getEntityClass())
            ->fetchAll();
    }

    public function getByBranchId(int $branchId)
    {
        return $this->getAllFluent()
            ->where('[branchId] = %i', $branchId)
            ->execute()
            ->setRowClass($this->getEntityClass())
            ->fetchAll();
    }

    /**
     * @param int $carId
     *
     * @return int
     */
    public function getCountCarsByMember($carId)
    {
        return $this->getCountFluent()
            ->where('[carId] = %i', $carId)
            ->fetchSingle();
    }
}
