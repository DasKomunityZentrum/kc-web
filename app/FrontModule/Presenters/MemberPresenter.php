<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberPresenter.php
 * User: Tomáš Babický
 * Date: 14.03.2021
 * Time: 23:33
 */

namespace App\FrontModule\Presenters;

use App\Model\Facades\MemberFacade;
use App\Model\Managers\MemberManager;
use App\Services\ProfilePhotoService;
use Nette\Application\UI\Presenter;

/**
 * Class MemberPresenter
 *
 * @package App\FrontModule
 */
class MemberPresenter extends Presenter
{
    /**
     * @var MemberFacade $memberFacade
     */
    private MemberFacade $memberFacade;

    /**
     * @var ProfilePhotoService $profilePhotoService
     */
    private ProfilePhotoService $profilePhotoService;

    /**
     * MemberPresenter constructor.
     *
     * @param MemberFacade $memberFacade
     * @param ProfilePhotoService $profilePhotoService
     */
    public function __construct(
        MemberFacade $memberFacade,
        ProfilePhotoService $profilePhotoService
    ) {
        parent::__construct();

        $this->memberFacade = $memberFacade;
        $this->profilePhotoService = $profilePhotoService;
    }

    public function renderDefault()
    {
        $members = $this->memberFacade->getAll();

        $this->template->memberRows = array_chunk($members, 3);
        $this->template->profilePhotoDir = $this->profilePhotoService->getRelativeDir();
        $this->template->memberCount = count($members);
    }
}
