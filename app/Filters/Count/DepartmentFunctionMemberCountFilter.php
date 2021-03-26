<?php
/**
 *
 * Created by PhpStorm.
 * Filename: DepartmentFunctionMemberCountFilter.php
 * User: Tomáš Babický
 * Date: 21.03.2021
 * Time: 15:33
 */

namespace App\Filters\Count;


use App\Services\CountWordItService;

class DepartmentFunctionMemberCountFilter
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
            return 'Bohužel, ještě žádné Členskou Funkci Oddělení nemáme';
        } elseif ($count === 1) {
            return 'Dneska už máme jednu Členskou Funkci Oddělení!';
        } elseif ($count < 5) {
            $parsed = $this->countWordItService->parse($count);

            return 'Dneska už máme ' . $parsed . ' Členské Funkce Oddělení';
        } elseif ($count >= 5) {
            $parsed = $this->countWordItService->parse($count);

            return 'Dneska už máme '. $parsed. ' Členských Funkcí Oddělení';
        }
    }
}
