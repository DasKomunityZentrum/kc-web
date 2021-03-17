<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CaseFIlter.php
 * User: Tomáš Babický
 * Date: 11.03.2021
 * Time: 20:08
 */

namespace App\AdminModule\Filters;

use App\Model\Entities\CauseEntity;

/**
 * Class CaseFilter
 *
 * @package App\Filters
 */
class CauseFilter
{
    /**
     * @param CauseEntity $causeEntity
     */
    public function __invoke(CauseEntity $causeEntity)
    {
        return $causeEntity->name;
    }
}
