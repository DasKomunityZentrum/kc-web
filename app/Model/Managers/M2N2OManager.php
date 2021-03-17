<?php
/**
 *
 * Created by PhpStorm.
 * Filename: M2N2OManager.php
 * User: Tomáš Babický
 * Date: 16.03.2021
 * Time: 3:09
 */

namespace App\Model\Managers;

use Dibi\Connection;
use Dibi\Fluent;
use Dibi\Result;

/**
 * Class M2N2OManager
 *
 * @package App\Model\Managers
 */
abstract class M2N2OManager extends DibiManager
{
    /**
     * @var CrudManager $leftTable
     */
    private CrudManager $leftTable;

    /**
     * @var string $leftKey
     */
    private string $leftKey;

    /**
     * @var CrudManager $middleTable
     */
    private CrudManager $middleTable;

    /**
     * @var string $middleKey
     */
    private string $middleKey;


    /**
     * @var CrudManager $rightTable
     */
    private CrudManager $rightTable;

    /**
     * @var string $rightKey
     */
    private string $rightKey;

    /**
     * M2NManager constructor.
     *
     * @param CrudManager $leftTable
     * @param CrudManager $middleTable
     * @param CrudManager $rightTable
     * @param Connection $dibi
     */
    public function __construct(
        CrudManager $leftTable,
        CrudManager $middleTable,
        CrudManager $rightTable,
        Connection $dibi
    ) {
        parent::__construct($dibi);

        $this->leftTable = $leftTable;
        $this->middleTable = $middleTable;
        $this->rightTable = $rightTable;

        $this->leftKey = $this->getDibi()
            ->getDatabaseInfo()
            ->getTable($this->getTableName())
            ->getPrimaryKey()
            ->getColumns()[0]
            ->getName();

        $this->middleKey = $this->getDibi()
            ->getDatabaseInfo()
            ->getTable($this->getTableName())
            ->getPrimaryKey()
            ->getColumns()[1]
            ->getName();

        $this->rightKey = $this->getDibi()
            ->getDatabaseInfo()
            ->getTable($this->getTableName())
            ->getPrimaryKey()
            ->getColumns()[2]
            ->getName();
    }

    public abstract function getTableName();

    public abstract function getEntityClass();

    public function getAllFluent() : Fluent
    {
        return $this->getDibi()->select('*')
            ->from($this->getTableName());
    }

    public function getAll() : array
    {
        return $this->getAllFluent()
            ->execute()
            ->setRowClass($this->getEntityClass())
            ->fetchAll();
    }


    public function getByLeftId($leftId) : array
    {
        return $this->getAllFluent()
            ->where('%n = %i', $this->leftKey, $leftId)
            ->execute()
            ->setRowClass($this->getEntityClass())
            ->fetchAll();
    }

    public function getByMiddleId($middleId) : array
    {
        return $this->getAllFluent()
            ->where('%n = %i', $this->middleKey, $middleId)
            ->execute()
            ->setRowClass($this->getEntityClass())
            ->fetchAll();
    }

    public function getByRightId($rightId) : array
    {
        return $this->getAllFluent()
            ->where('%n = %i', $this->rightKey, $rightId)
            ->execute()
            ->setRowClass($this->getEntityClass())
            ->fetchAll();
    }

    public function getByLeftIdAndRightId(int $leftId, int $rightId)
    {
        return $this->getAllFluent()
            ->where('%n = %i', $this->leftKey, $leftId)
            ->where('%n = %i', $this->rightKey, $rightId)
            ->execute()
            ->setRowClass($this->getEntityClass())
            ->fetch();
    }

    public function getByLeftIdAndMiddleIdAndRightId(int $leftId, int $middleId, ?int $rightId)
    {
        if ($rightId === null) {
            return $this->getAllFluent()
                ->where('%n = %i', $this->leftKey, $leftId)
                ->where('%n = %i', $this->middleKey, $middleId)
                ->execute()
                ->setRowClass($this->getEntityClass())
                ->fetch();
        } else {
            return $this->getAllFluent()
                ->where('%n = %i', $this->leftKey, $leftId)
                ->where('%n = %i', $this->middleKey, $middleId)
                ->where('%n = %i', $this->rightKey, $rightId)
                ->execute()
                ->setRowClass($this->getEntityClass())
                ->fetch();
        }

    }

    public function insert(array $values)
    {
        return $this->getDibi()
            ->insert($this->getTableName(), $values)
            ->execute();
    }

    /**
     * @param int $leftId
     *
     * @return Result|int|null
     */
    public function deleteByLefttId(int $leftId)
    {
        return $this->getDibi()
            ->delete($this->getTableName())
            ->where('%n = %i', $this->leftKey, $leftId)
            ->execute();
    }

    /**
     * @param int $rightId
     *
     * @return Result|int|null
     */
    public function deleteByRightId(int $rightId)
    {
        return $this->getDibi()
            ->delete($this->getTableName())
            ->where('%n = %i', $this->rightKey, $rightId)
            ->execute();
    }

    /**
     * @param int $leftId
     * @param int $rightId
     *
     * @return Result|int|null
     */
    public function deleteByLeftAndRight(int $leftId, int $rightId)
    {
        return $this->getDibi()
            ->delete($this->getTableName())
            ->where('%n = %i', $this->leftKey, $leftId)
            ->where('%n = %i', $this->rightKey, $rightId)
            ->execute();
    }

    /**
     * @param int $leftId
     * @param int $rightId
     *
     * @return Result|int|null
     */
    public function deleteByLeftAnMidlleAnddRight(int $leftId, int $middleId, int $rightId)
    {
        return $this->getDibi()
            ->delete($this->getTableName())
            ->where('%n = %i', $this->leftKey, $leftId)
            ->where('%n = %i', $this->middleKey, $middleId)
            ->where('%n = %i', $this->rightKey, $rightId)
            ->execute();
    }
}
