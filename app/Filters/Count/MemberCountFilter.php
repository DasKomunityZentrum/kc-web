<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberCountFIlter.php
 * User: Tomáš Babický
 * Date: 21.03.2021
 * Time: 14:34
 */

namespace App\Filters\Count;

use App\Services\CountWordHeService;

/**
 * Class MemberCountFilter
 *
 * @package App\Filters\Count
 */
class MemberCountFilter
{
    /**
     * @var CountWordHeService $countWordHeService
     */
    private CountWordHeService $countWordHeService;

    /**
     * BranchCountFilter constructor.
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
        if ($count === 0) {
            return 'Bohužel, ještě žádného Člena nemáme';
        } elseif ($count === 1) {
            return 'Dneska už máme jedno Člena!';
        } elseif ($count < 5) {
            $parsed = $this->countWordHeService->parse($count);

            return 'Dneska už máme ' . $parsed . ' Členi';
        } elseif ($count >= 5) {
            $parsed = $this->countWordHeService->parse($count);

            return 'Dneska už máme '. $parsed. ' Členů';
        }
    }
}