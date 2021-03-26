<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CrudManager.php
 * User: Tomáš Babický
 * Date: 09.03.2021
 * Time: 23:52
 */

namespace App\Model\Managers;

use dibi;
use Dibi\Connection;
use Dibi\Fluent;
use Dibi\Result;
use Dibi\Row;

/**
 * Class CrudManager
 *
 * @package App\Managers
 */
abstract class CrudManager extends DibiManager
{
    /**
     * @var string $primaryKey
     */
    private string $primaryKey;

    /**
     * CrudManager constructor.
     *
     * @param Connection $dibi
     */
    public function __construct(Connection $dibi)
    {
        parent::__construct($dibi);

        $primaryKey = $this->getDibi()
            ->getDatabaseInfo()
            ->getTable($this->getTableName())
            ->getPrimaryKey()
            ->getColumns()[0]
            ->getName();

        $this->primaryKey = $primaryKey;
    }

    /**
     * @return string
     */
    public abstract function getTableName() : string;

    public abstract function getEntityClass() : string;

    /**
     * @return Fluent
     */
    public function getAllFluent() : Fluent
    {
        return $this->getDibi()
            ->select('*')
            ->from($this->getTableName());
    }

    public function getCountFluent() : Fluent
    {
        return $this->getDibi()
            ->select('COUNT(*)')
            ->from($this->getTableName());
    }

    /**
     * @return array
     */
    public function getAll() : array
    {
        return $this->getAllFluent()
            ->execute()
            ->setRowClass($this->getEntityClass())
            ->fetchAll();
    }

    /**
     * @param int $id
     *
     * @return array|Row|null
     */
    public function getByPrimaryKey(int $id)
    {
        return $this->getAllFluent()
            ->where('%n = %i', $this->primaryKey, $id)
            ->execute()
            ->setRowClass($this->getEntityClass())
            ->fetch();
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return Result|int|null
     */
    public function updateByPrimaryKey(int $id, array $data)
    {
        return $this->getDibi()
            ->update($this->getTableName(), $data)
            ->where('%n = %i', $this->primaryKey, $id)
            ->execute();
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function insert(array $data) : int
    {
        return $this->getDibi()
            ->insert($this->getTableName(),$data)
            ->execute(dibi::IDENTIFIER);
    }

    /**
     * @param int $id
     *
     * @return Result|int|null
     */
    public function deleteByPrimaryKey(int $id)
    {
        return $this->getDibi()
            ->delete($this->getTableName())
            ->where('%n = %i', $this->primaryKey, $id)
            ->execute();
    }
}