<?php
/**
 *
 * Created by PhpStorm.
 * Filename: FunctionManager.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 0:50
 */

namespace App\Model\Managers;

use App\AdminModule\Filters\FunctionFilter;
use App\Model\Entities\FunctionEntity;
use App\Model\Tables;
use Dibi\Connection;

/**
 * Class FunctionManager
 *
 * @package App\Managers
 */
class FunctionManager extends CrudManager
{
    /**
     * @var FunctionFilter $functionFilter
     */
    private FunctionFilter $functionFilter;

    /**
     * FunctionManager constructor.
     *
     * @param Connection $dibi
     * @param FunctionFilter $functionFilter
     */
    public function __construct(
        Connection $dibi,
        FunctionFilter $functionFilter
    ) {
        parent::__construct($dibi);

        $this->functionFilter = $functionFilter;
    }

    /**
     * @inheritDoc
     */
    public function getTableName(): string
    {
        return Tables::FUNCTIONS_TABLE;
    }

    /**
     * @return string
     */
    public function getEntityClass() : string
    {
        return FunctionEntity::class;
    }

    /**
     * @return array
     */
    public function getPairsForSelect() : array
    {
        $functions = $this->getAll();
        $functionFilter = $this->functionFilter;

        $functionPairs = [];

        foreach ($functions as $function) {
            $functionPairs[$function->id] = $functionFilter($function);
        }

        return $functionPairs;
    }
}