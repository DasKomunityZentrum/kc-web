<?php
/**
 *
 * Created by PhpStorm.
 * Filename: DepartmentPresenter.php
 * User: Tomáš Babický
 * Date: 14.03.2021
 * Time: 23:35
 */

namespace App\FrontModule\Presenters;

use App\Model\Facades\Department2Functions2MembersFacade;
use Nette\Application\UI\Presenter;

/**
 * Class DepartmentPresenter
 *
 * @package App\FrontModule\Presenters
 */
class DepartmentPresenter extends Presenter
{
    /**
     * @var Department2Functions2MembersFacade $department2Function2MemberFacade
     */
    private Department2Functions2MembersFacade $department2Function2MemberFacade;

    /**
     * DepartmentPresenter constructor.
     *
     * @param Department2Functions2MembersFacade $department2Function2MemberFacade
     */
    public function __construct(Department2Functions2MembersFacade $department2Function2MemberFacade)
    {
        parent::__construct();

        $this->department2Function2MemberFacade = $department2Function2MemberFacade;
    }

    public function renderDefault()
    {
        $departments = $this->department2Function2MemberFacade->getAll();

        $this->template->departments = $departments;
    }
}
