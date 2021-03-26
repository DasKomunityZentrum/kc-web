<?php
/**
 *
 * Created by PhpStorm.
 * Filename: LogoutPresenter.php
 * User: Tomáš Babický
 * Date: 18.03.2021
 * Time: 0:10
 */

namespace App\AdminModule\Presenters;

use Nette\Application\UI\Presenter;

/**
 * Class LogoutPresenter
 *
 * @package App\AdminModule\Presenters
 */
class LogoutPresenter extends Presenter
{
    public function startup() : void
    {
        parent::startup();

        if (!$this->user->loggedIn) {
            $this->flashMessage('Nejste přihlášený', 'warning');
            $this->redirect('Login:default');
        }
    }

    public function actionDefault() : void
    {
        $this->user->logout(true);
        $this->flashMessage('Odhlášení bylo úspěšné', 'success');
        $this->redirect(':Front:Homepage:default');
    }
}
