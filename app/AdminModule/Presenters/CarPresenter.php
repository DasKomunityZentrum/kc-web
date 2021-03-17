<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CarPresenter.php
 * User: Tomáš Babický
 * Date: 10.03.2021
 * Time: 21:23
 */

namespace App\AdminModule\Presenters;

use App\Form\KCForm;
use App\Form\KcFormRenderer;
use App\Model\Managers\CarManager;
use App\Model\Managers\MemberManager;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;

/**
 * Class CarPresenter
 *
 * @package App\AdminModule\Presenters
 */
class CarPresenter extends Presenter
{
    /**
     * @var CarManager $carManager
     */
    private CarManager $carManager;

    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * CarPresenter constructor.
     *
     * @param CarManager $carManager
     * @param MemberManager $memberManager
     */
    public function __construct(
        CarManager $carManager,
        MemberManager $memberManager
    ) {
        parent::__construct();

        $this->carManager = $carManager;
        $this->memberManager = $memberManager;
    }

    public function startup()
    {
        parent::startup();

        if (!$this->user->loggedIn) {
            $this->flashMessage('Nejste přihlášený', 'warning');
            $this->redirect('Login:default');
        }
    }

    public function renderDefault()
    {
        $cars = $this->carManager->getAll();

        $this->template->cars = $cars;
    }

    /**
     * @param int|null $id
     */
    public function actionEdit(int $id = null)
    {
        if ($id) {
            $car = $this->carManager->getByPrimaryKey($id);

            if (!$car) {
                $this->error('Auto KC nenalezeno');
            }

            $this['carForm']->setDefaults($car);
        }
    }

    public function renderEdit(int $id = null)
    {
        if ($id) {
            $members = $this->memberManager->getByCarId($id);
        } else {
            $members = [];
        }


        $this->template->members = $members;

    }

    /**
     * @param int $id
     */
    public function actionDelete(int $id)
    {
        $this->carManager->deleteByPrimaryKey($id);
        $this->flashMessage('Auto KC bylo smazáno', 'success');
        $this->redirect('Car:default');
    }

    /**
     * @return Form
     */
    public function createComponentCarForm() : Form
    {
        $form = new KCForm();

        $form->addText('name', 'Jméno');
        $form->addCheckbox('active', 'Aktivní');
        $form->addText('nick', 'Přezdívka');
        $form->addText('ccc', 'Objem')
            ->addRule(Form::FLOAT, 'Obsah musí být desetinný');
        $form->addText('kw', 'KW');
        $form->addTextArea('note', 'Poznámka');

        $form->addSubmit('send', 'Uložit Auto KC');

        $form->onSuccess[] = [$this, 'carFormSuccess'];

        return $form;
    }

    /**
     * @param Form $form
     * @param ArrayHash $values
     */
    public function carFormSuccess(Form $form, ArrayHash $values)
    {
        $id = $this->getParameter('id');

        if ($id) {
            $this->carManager->updateByPrimaryKey($id, (array) $values);
            $this->flashMessage('Auto KC bylo aktualizováno', 'success');
        } else {
            $id = $this->carManager->insert((array) $values);
            $this->flashMessage('Auto KC bylo přidáno', 'success');
        }

        $this->redirect('Car:edit', $id);
    }
}
