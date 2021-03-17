<?php
/**
 *
 * Created by PhpStorm.
 * Filename: FunctionMemberPresenter.php
 * User: Tomáš Babický
 * Date: 17.03.2021
 * Time: 22:43
 */

namespace App\FrontModule\Presenters;

use App\Model\Facades\Function2MembersFacade;
use Nette\Application\UI\Presenter;

/**
 * Class FunctionMemberPresenter
 *
 * @package App\FrontModule\Presenters
 */
class FunctionMemberPresenter extends Presenter
{
    /**
     * @var Function2MembersFacade $function2MembersFacade
     */
    private Function2MembersFacade $function2MembersFacade;

    /**
     * FunctionMemberPresenter constructor.
     *
     * @param Function2MembersFacade $function2MembersFacade
     */
    public function __construct(Function2MembersFacade $function2MembersFacade)
    {
        parent::__construct();

        $this->function2MembersFacade = $function2MembersFacade;
    }

    public function renderDefault()
    {
        $functions2Members = $this->function2MembersFacade->getAll();

        $this->template->functions2Members = $functions2Members;
    }
}
