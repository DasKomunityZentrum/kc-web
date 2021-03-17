<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CausePresenter.php
 * User: Tomáš Babický
 * Date: 16.03.2021
 * Time: 2:11
 */

namespace App\FrontModule\Presenters;

use App\Model\Facades\CauseFacade;
use Nette\Application\UI\Presenter;

/**
 * Class CausePresenter
 *
 * @package App\FrontModule\Presenters
 */
class CausePresenter extends Presenter
{
    /**
     * @var CauseFacade $causeFacade
     */
    private CauseFacade $causeFacade;

    /**
     * CausePresenter constructor.
     *
     * @param CauseFacade $causeFacade
     */
    public function __construct(CauseFacade $causeFacade)
    {
        parent::__construct();

        $this->causeFacade = $causeFacade;
    }

    public function renderDefault()
    {
        $causes = $this->causeFacade->getAll();

        $this->template->causes = $causes;
    }
}
