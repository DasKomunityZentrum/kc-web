<?php
/**
 *
 * Created by PhpStorm.
 * Filename: CauseCountFilter.php
 * User: Tomáš Babický
 * Date: 21.03.2021
 * Time: 14:32
 */

namespace App\Filters\Count;

use App\Services\CountWordSheService;

/**
 * Class CauseCountFilter
 *
 * @package App\Filters\Count
 */
class CauseCountFilter
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
            return 'Bohužel, ještě žádnou Kauzu nemáme';
        } elseif ($count === 1) {
            return 'Dneska už máme jednu Kauzu!';
        } elseif ($count < 5) {
            $parsed = $this->countWordSheService->parse($count);

            return 'Dneska už máme ' . $parsed . ' Kauzy';
        } elseif ($count >= 5) {
            $parsed = $this->countWordSheService->parse($count);

            return 'Dneska už máme '. $parsed. ' Kauz';
        }
    }
}
