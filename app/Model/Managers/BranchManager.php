<?php
/**
 *
 * Created by PhpStorm.
 * Filename: BranchManager.php
 * User: Tomáš Babický
 * Date: 13.03.2021
 * Time: 11:47
 */

namespace App\Model\Managers;

use App\AdminModule\Filters\BranchFilter;
use App\Model\Entities\BranchEntity;
use App\Model\Tables;
use Dibi\Connection;

/**
 * Class BranchManager
 *
 * @package App\Model\Managers
 */
class BranchManager extends CrudManager
{
    /**
     * @var BranchFilter $branchFilter
     */
    private BranchFilter $branchFilter;

    /**
     * BranchManager constructor.
     *
     * @param BranchFilter $branchFilter
     * @param Connection $dibi
     */
    public function __construct(
        BranchFilter $branchFilter,
        Connection $dibi
    ) {
        parent::__construct($dibi);

        $this->branchFilter = $branchFilter;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return Tables::BRANCH_TABLE;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return BranchEntity::class;
    }

    /**
     * @return array
     */
    public function getPairsForSelect() : array
    {
        $branches = $this->getAll();
        $branchFilter = $this->branchFilter;

        $branchPairs = [];

        foreach ($branches as $branch) {
            $branchPairs[$branch->id] = $branchFilter($branch);
        }

        return $branchPairs;
    }
}
