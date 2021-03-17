<?php
/**
 *
 * Created by PhpStorm.
 * Filename: DibiManager.php
 * User: Tomáš Babický
 * Date: 09.03.2021
 * Time: 23:49
 */

namespace App\Model\Managers;

use Dibi\Connection;

/**
 * Class DibiManager
 *
 * @package App\Managers
 */
class DibiManager
{
    /**
     * @var Connection $dibi
     */
    private Connection $dibi;

    /**
     * DibiManager constructor.
     *
     * @param Connection $dibi
     */
    public function __construct(Connection $dibi)
    {
        $this->dibi = $dibi;
    }

    public function getDibi() : Connection
    {
        return $this->dibi;
    }
}
