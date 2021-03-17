<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CarManager.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 21:28
 */

namespace App\Model\Managers;

use App\AdminModule\Filters\CarFilter;
use App\Model\Entities\CarEntity;
use App\Model\Tables;
use Dibi\Connection;

/**
 * Class CarManager
 *
 * @package App\Model\Managers
 */
class CarManager extends CrudManager
{
    /**
     * @var CarFilter $carFilter
     */
    private CarFilter $carFilter;

    /**
     * CarManager constructor.
     *
     * @param CarFilter $carFilter
     * @param Connection $dibi
     */
    public function __construct(
        CarFilter $carFilter,
        Connection $dibi,
    ) {
        parent::__construct($dibi);

        $this->carFilter = $carFilter;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return Tables::CAR_TABLE;
    }

    /**
     * @return string
     */
    public function getEntityClass() : string
    {
        return CarEntity::class;
    }

    /**
     * @return array
     */
    public function getPairsForSelect() : array
    {
        $cars = $this->getAll();
        $carFilter = $this->carFilter;

        $carPairs = [];

        foreach ($cars as $car) {
            $carPairs[$car->id] = $carFilter($car);
        }

        return $carPairs;
    }
}
