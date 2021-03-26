<?php
/**
 *
 * Created by PhpStorm.
 * Filename: ProfilePhotoService.php
 * User: Tomáš Babický
 * Date: 12.03.2021
 * Time: 21:30
 */

namespace App\Services;

/**
 * Class ProfilePhotoService
 *
 * @package App\Services
 */
class ProfilePhotoService
{
    /**
     * @var string $wwwDir
     */
    private string $wwwDir;

    /**
     * @param string $wwwDir
     */
    public function __construct(string $wwwDir)
    {
        $this->wwwDir = $wwwDir;
    }

    /**
     * @return string
     */
    public function getDir() : string
    {
        $sep = DIRECTORY_SEPARATOR;

        return $this->wwwDir . $sep . $this->getRelativeDir();
    }

    /**
     * @return string
     */
    public function getRelativeDir() : string
    {
        $sep = DIRECTORY_SEPARATOR;

        return 'images' . $sep . 'profile_photos' . $sep;
    }
}
