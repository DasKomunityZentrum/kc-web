<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use Dibi\Connection;
use Nette;

/**
 * Class HomepagePresenter
 *
 * @package App\AdminModule\Presenters
 */
final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(Connection $dibi)
    {
        $dibi->select('*')
            ->from('member')
            ->fetchAll();
    }

}
