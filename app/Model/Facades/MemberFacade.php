<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberFacade.php
 * User: Tomáš Babický
 * Date: 13.03.2021
 * Time: 12:44
 */

namespace App\Model\Facades;

use App\Model\Entities\BranchEntity;
use App\Model\Entities\CarEntity;
use App\Model\Entities\MemberEntity;
use App\Model\Managers\BranchManager;
use App\Model\Managers\CarManager;
use App\Model\Managers\MemberManager;

/**
 * Class MemberFacade
 *
 * @package App\Model\Facades
 */
class MemberFacade
{
    /**
     * @var BranchManager $branchManager
     */
    private BranchManager $branchManager;

    /**
     * @var CarManager $carManager
     */
    private CarManager $carManager;

    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * MemberFacade constructor.
     *
     * @param BranchManager $branchManager
     * @param CarManager $carManager
     * @param MemberManager $memberManager
     */
    public function __construct(
        BranchManager $branchManager,
        CarManager $carManager,
        MemberManager $memberManager
    ) {
        $this->branchManager = $branchManager;
        $this->carManager = $carManager;
        $this->memberManager = $memberManager;
    }

    /**
     * @param MemberEntity[] $members
     * @param CarEntity[] $cars
     * @param BranchEntity[] $branches
     *
     * @return MemberEntity[]
     */
    public function join(array $members, array $cars, array $branches) : array
    {
        foreach ($members as $member) {
            foreach ($cars as $car) {
                if ($member->carId === $car->id) {
                    $member->carEntity = $car;

                    break;
                }
            }

            foreach ($branches as $branch) {
                if ($member->branchId === $branch->id) {
                    $member->branchEntity = $branch;

                    break;
                }
            }
        }

        return $members;
    }

    public function getAll(): array
    {
        $members = $this->memberManager->getAll();
        $cars = $this->carManager->getAll();
        $branches = $this->branchManager->getAll();

        return $this->join($members, $cars, $branches);
    }
}
