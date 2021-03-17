<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberFunctionPresenter.php
 * User: Tomáš Babický
 * Date: 17.03.2021
 * Time: 22:06
 */

namespace App\FrontModule\Presenters;

use App\Model\Facades\Member2FunctionsFacade;
use Nette\Application\UI\Presenter;

/**
 * Class MemberFunctionPresenter
 *
 * @package App\FrontModule\templates\Department
 */
class MemberFunctionPresenter extends Presenter
{
    /**
     * @var Member2FunctionsFacade $member2FunctionsFacade
     */
    private Member2FunctionsFacade $member2FunctionsFacade;

    /**
     * MemberFunctionPresenter constructor.
     *
     * @param Member2FunctionsFacade $member2FunctionsFacade
     */
    public function __construct(Member2FunctionsFacade $member2FunctionsFacade)
    {
        parent::__construct();

        $this->member2FunctionsFacade = $member2FunctionsFacade;
    }

    public function renderDefault()
    {
        $members2Functions = $this->member2FunctionsFacade->getAll();

        $this->template->members2Functions = $members2Functions;
    }
}
