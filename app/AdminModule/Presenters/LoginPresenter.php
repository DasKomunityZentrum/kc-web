<?php
/**
 *
 * Created by PhpStorm.
 * Filename: LoginPresenter.php
 * User: Tomáš Babický
 * Date: 17.03.2021
 * Time: 23:47
 */

namespace App\AdminModule\Presenters;

use App\Form\KcForm;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;

/**
 * Class LoginPresenter
 *
 * @package App\AdminModule\Presenters
 */
class LoginPresenter extends Presenter
{
    public function actionDefault()
    {
        if ($this->user->loggedIn) {
            $this->flashMessage('Už jste přihlášený, není potřeba se znovu přihlašovat', 'info');
            $this->redirect('Homepage:default');
        }
    }

    public function loginFormRenderer($form)
    {
        $renderer = $form->getRenderer();
        $renderer->wrappers['control']['container'] = 'div class=col-sm-4';
    }

    /**
     * @return KcForm
     */
    public function createComponentLoginForm() : KcForm
    {
        $form = new KcForm();

        $form->addText('username', 'Jméno');
        $form->addPassword('password', 'Heslo');
        $form->addSubmit('send', 'Přihlásit');

        $form->onSuccess[] = [$this, 'loginFormSuccess'];
        $form->onRender[] = [$this, 'loginFormRenderer'];

        return $form;
    }

    /**
     * @param Form $form
     * @param ArrayHash $values
     */
    public function loginFormSuccess(Form $form, ArrayHash $values)
    {
        try {
            $this->user->login($values->username, $values->password);
            $this->redirect('Homepage:default');
        } catch (\Nette\Security\AuthenticationException $e) {
            $this->flashMessage('Uživatelské jméno nebo heslo je nesprávné');
        }
    }
}
