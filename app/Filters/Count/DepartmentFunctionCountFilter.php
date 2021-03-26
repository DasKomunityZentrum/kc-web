<?php
/**
 *
 * Created by PhpStorm.
 * Filename: DepartmentFunctionCountFilter.php
 * User: Tomáš Babický
 * Date: 21.03.2021
 * Time: 15:33
 */

namespace App\Filters\Count;


use App\Services\CountWordItService;

class DepartmentFunctionCountFilter
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
            return 'Bohužel, ještě žádné Funkce Oddělení nemáme';
        } elseif ($count === 1) {
            return 'Dneska už máme jednu Funkci Oddělení!';
        } elseif ($count < 5) {
            $parsed = $this->countWordItService->parse($count);

            return 'Dneska už máme ' . $parsed . ' Funkcí Oddělení';
        } elseif ($count >= 5) {
            $parsed = $this->countWordItService->parse($count);

            return 'Dneska už máme '. $parsed. ' Funkcí Oddělení';
        }
    }
}
