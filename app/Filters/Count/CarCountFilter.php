<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CarCountFilter.php
 * User: Tomáš Babický
 * Date: 21.03.2021
 * Time: 14:32
 */

namespace App\Filters\Count;

use App\Services\CountWordItService;

/**
 * Class CarCountFilter
 *
 * @package App\Filters\Count
 */
class CarCountFilter
{
    /**
     * @var CountWordItService $countWordItService
     */
    private CountWordItService $countWordItService;

    /**
     * BranchCountFilter constructor.
     *
     * @param CountWordItService $countWordItService
     */
    public function __construct(CountWordItService $countWordItService)
    {
        $this->countWordItService = $countWordItService;
    }

    /**
     * @param int $count
     *
     * @return string
     */
    public function __invoke(int $count) : string
    {
        if ($count === 0) {
            return 'Bohužel, ještě žádné Auto nemáme';
        } elseif ($count === 1) {
            return 'Dneska už máme jedno Auto!';
        } elseif ($count < 5) {
            $parsed = $this->countWordItService->parse($count);

            return 'Dneska už máme ' . $parsed . ' Auta';
        } elseif ($count >= 5) {
            $parsed = $this->countWordItService->parse($count);

            return 'Dneska už máme '. $parsed. ' Aut';
        }
    }
}
