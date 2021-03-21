<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MemberFunctionCountFilter.php
 * User: Tomáš Babický
 * Date: 21.03.2021
 * Time: 15:26
 */

namespace App\Filters\Count;

use App\Services\CountWordSheService;

/**
 * Class MemberFunctionCountFilter
 *
 * @package App\Filters\Count
 */
class MemberFunctionCountFilter
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
            return 'Bohužel, ještě žádnou Členskou Funkci nemáme';
        } elseif ($count === 1) {
            return 'Dneska už máme jednu Členskou Funkci!';
        } elseif ($count < 5) {
            $parsed = $this->countWordSheService->parse($count);

            return 'Dneska už máme ' . $parsed . ' Členské Funkce';
        } elseif ($count >= 5) {
            $parsed = $this->countWordSheService->parse($count);

            return 'Dneska už máme '. $parsed. ' Členských Funkcí';
        }
    }
}