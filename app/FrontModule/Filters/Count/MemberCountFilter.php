<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberCountFIlter.php
 * User: Tomáš Babický
 * Date: 15.03.2021
 * Time: 3:56
 */

namespace App\FrontModule\Filters\Count;

use App\Services\CountWordHeService;

/**
 * Class MemberCountFilter
 *
 * @package App\FrontModule\Filters
 */
class MemberCountFilter
{
    /**
     * @var CountWordHeService $countWordHeService
     */
    private CountWordHeService $countWordHeService;

    /**
     * MemberCountFilter constructor.
     *
     * @param CountWordHeService $countWordHeService
     */
    public function __construct(CountWordHeService $countWordHeService)
    {
        $this->countWordHeService = $countWordHeService;
    }

    /**
     * @param int $count
     *
     * @return string
     */
     public function __invoke(int $count) : string
     {
        if ($count > 0 && $count <= 10) {
            return $this->countWordHeService->fromZeroToTen($count);
        } elseif ($count >  10 && $count < 20) {
            return  $this->countWordHeService->fromElevenToNineTeen($count);
        } elseif ($count > 20 &&  99) {
            $tens = (int)substr((string) $count, 0, 1);
            $units = (int)substr((string) $count, 1, 1);

            return $this->countWordHeService->tens($tens) . ' ' . $this->countWordHeService->fromZeroToTenHe($units);
        } else {
            return (string)$count;
        }
    }
}
