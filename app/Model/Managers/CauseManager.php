<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CauseManager.php
 * User: Tomáš Babický
 * Date: 11.03.2021
 * Time: 20:07
 */

namespace App\Model\Managers;

use App\Model\Entities\CauseEntity;
use App\Model\Tables;
use Dibi\Row;

/**
 * Class CauseManager
 *
 * @package App\Model\Managers
 */
class CauseManager extends CrudManager
{

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return Tables::CASE_TABLE;
    }

    /**
     * @return string
     */
    public function getEntityClass() : string
    {
        return CauseEntity::class;
    }

    /**
     * @param int $memberId
     *
     * @return Row[]
     */
    public function getByMemberId(int $memberId) : array
    {
        return $this->getAllFluent()
            ->where('[memberId] = %i', $memberId)
            ->execute()
            ->setRowClass($this->getEntityClass())
            ->fetchAll();
    }
}