<?php
/**
 *
 * Created by PhpStorm.
 * Filename: FunctionCountFilter.php
 * User: Tomáš Babický
 * Date: 21.03.2021
 * Time: 14:33
 */

namespace App\Filters\Count;

use App\Services\CountWordSheService;

/**
 * Class FunctionCountFilter
 *
 * @package App\Filters\Count
 */
class FunctionCountFilter
{
    /**
     * @var CountWordSheService $countWordSheService
     */
    private CountWordSheService $countWordSheService;

    /**
     * BranchCountFilter constructor.
     *
     * @param CountWordSheService $countWordSheService
     */
    public function __construct(CountWordSheService $countWordSheService)
    {
        $this->countWordSheService = $countWordSheService;
    }

    /**
     * @param int $count
     *
     * @return string
     */
    public function __invoke(int $count) : string
    {
        if ($count === 0) {
            return 'Bohužel, ještě žádnou Funkci nemáme';
        } elseif ($count === 1) {
            return 'Dneska už máme jednu Funkci!';
        } elseif ($count < 5) {
            $parsed = $this->countWordSheService->parse($count);

            return 'Dneska už máme ' . $parsed . ' Funkce';
        } elseif ($count >= 5) {
            $parsed = $this->countWordSheService->parse($count);

            return 'Dneska už máme '. $parsed. ' Funkcí';
        }
    }
}
