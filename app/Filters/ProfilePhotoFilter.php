<?php
/**
 *
 * Created by PhpStorm.
 * Filename: ProfilePhotoFilter.php
 * User: Tomáš Babický
 * Date: 15.03.2021
 * Time: 0:20
 */

namespace App\Filters;

use App\Model\Entities\MemberEntity;
use App\Services\ProfilePhotoService;

/**
 * Class ProfilePhotoFilter
 * @package App\Filters
 */
class ProfilePhotoFilter
{
    /**
     * @var ProfilePhotoService $profilePhotoService
     */
    private ProfilePhotoService $profilePhotoService;

    /**
     * ProfilePhotoFilter constructor.
     *
     * @param ProfilePhotoService $profilePhotoService
     */
    public function __construct(
        ProfilePhotoService $profilePhotoService
    ) {
        $this->profilePhotoService = $profilePhotoService;
    }

    /**
     * @param MemberEntity $memberEntity
     *
     * @return string
     */
    public function __invoke(MemberEntity $memberEntity)
    {
        return sprintf('%s/%s.%s',
            $this->profilePhotoService->getRelativeDir(),
            $memberEntity->profilePhoto,
            $memberEntity->profilePhotoExtension
        );
    }
}
