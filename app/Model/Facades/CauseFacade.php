<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CauseFacade.php
 * User: Tomáš Babický
 * Date: 11.03.2021
 * Time: 20:28
 */

namespace App\Model\Facades;

use App\Model\Managers\CauseManager;
use App\Model\Managers\DepartmentManager;
use App\Model\Managers\MemberManager;

/**
 * Class CauseFacade
 *
 * @package App\Model\Facades
 */
class CauseFacade
{
    /**
     * @var CauseManager $causeManager
     */
    private CauseManager $causeManager;

    /**
     * @var DepartmentManager $departmentManager
     */
    private DepartmentManager $departmentManager;

    /**
     * @var MemberManager $memberManager
     */
    private MemberManager $memberManager;

    /**
     * CauseFacade constructor.
     *
     * @param CauseManager $causeManager
     * @param DepartmentManager $departmentManager
     * @param MemberManager $memberManager
     */
    public function __construct(
        CauseManager $causeManager,
        DepartmentManager $departmentManager,
        MemberManager $memberManager
    ) {
        $this->causeManager = $causeManager;
        $this->departmentManager = $departmentManager;
        $this->memberManager = $memberManager;
    }

    public function join(array $causes, array $members, array $departments)
    {
        foreach ($causes as $cause) {
            foreach ($members as $member) {
                if ($cause->memberId === $member->id) {
                    $cause->memberEntity = $member;
                    break;
                }
            }

            foreach ($departments as $department) {
                if ($cause->departmentId === $department->id) {
                    $cause->departmentEntity = $department;

                    break;
                }
            }
        }

        return $causes;
    }

    public function getAll()
    {
        $causes = $this->causeManager->getAll();
        $members = $this->memberManager->getAll();
        $departments = $this->departmentManager->getAll();

        return $this->join($causes, $members, $departments);
    }
}
