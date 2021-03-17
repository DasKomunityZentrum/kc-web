<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CarFilter.php
 * User: Tomáš Babický
 * Date: 15.03.2021
 * Time: 2:11
 */

namespace App\FrontModule\Filters;

use App\Model\Entities\MemberEntity;
use App\Model\Managers\MemberManager;

/**
 * Class CarFilter
 *
 * @package App\FrontModule\Filters
 */
class CarFilter
{
    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * CarFilter constructor.
     *
     * @param MemberManager $memberManager
     */
    public function __construct(MemberManager $memberManager)
    {
        $this->memberManager = $memberManager;
    }

    /**
     * @param MemberEntity $memberEntity
     *
     * @return string
     */
    public function __invoke(MemberEntity $memberEntity) : string
    {
        $carEntity = $memberEntity->carEntity;

        if ($carEntity) {
            $membersCount = $this->memberManager->getCountCarsByMember($carEntity->id);

            if ($membersCount === 1) {
                $car = 'Moje auto je ' . $carEntity->name;
            } else {
                $car = 'Naše auto je ' . $carEntity->name;
            }

            if ($carEntity->nick) {
                if ($membersCount === 1) {
                    $car .= ' a říkám mu ' . $carEntity->nick;
                } else {
                    $car .= ' a říkáme mu ' . $carEntity->nick;
                }
            }

            return  $car . '.';
        } else {
            $iDontDriveCar = [
                'Nejezdím autem.',
                'Nemám auto.',
                'Na auto nezbylo.',
                'Chodím pěšky.',
                'Nechám se vozit.'
            ];

            $iDontDriveCarCount = count($iDontDriveCar) - 1;

            return $iDontDriveCar[random_int(0, $iDontDriveCarCount)];
        }
    }
}
