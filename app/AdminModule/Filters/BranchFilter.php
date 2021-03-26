<?php
/**
 *
 * Created by PhpStorm.
 * Filename: BranchFilter.php
 * User: Tomáš Babický
 * Date: 13.03.2021
 * Time: 11:50
 */

namespace App\AdminModule\Filters;

use App\Model\Entities\BranchEntity;

/**
 * Class BranchFilter
 *
 * @package App\Filters
 */
class BranchFilter
{
    /**
     * @param BranchEntity $branchEntity
     *
     * @return string
     */
    public function __invoke(BranchEntity $branchEntity) : string
    {
        return $branchEntity->name;
    }
}
