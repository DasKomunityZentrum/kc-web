<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use Dibi\Connection;
use Nette;
use Nette\Application\UI\Presenter;

/**
 * Class HomepagePresenter
 *
 * @package App\AdminModule\Presenters
 */
final class HomepagePresenter extends Presenter
{
    public function startup() : void
    {
        parent::startup();

        if (!$this->user->loggedIn) {
            $this->flashMessage('Nejste přihlášený', 'warning');
            $this->redirect('Login:default');
        }
    }

    public function renderDefault() : void
    {
    }
}
