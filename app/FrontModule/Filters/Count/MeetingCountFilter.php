<?php
/**
 *
 * Created by PhpStorm.
 * Filename: MeetingCountFilter.php
 * User: Tomáš Babický
 * Date: 17.03.2021
 * Time: 23:11
 */

namespace App\FrontModule\Filters\Count;

use App\Services\CountWordItService;

/**
 * Class MeetingCountFilter
 *
 * @package App\FrontModule\Filters
 */
class MeetingCountFilter
{
    /**
     * @var CountWordItService $countWordItService
     */
    private CountWordItService $countWordItService;

    /**
     * MemberCountFilter constructor.
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
            return 'Bohužel, ještě žádnoé Zasedání nemáme';
        } elseif ($count === 1) {
            return 'Dneska už máme jedno Zasedání!';
        } elseif ($count < 5) {
            $parsed = $this->countWordItService->parse($count);

            return 'Dneska už jsou ' . $parsed . ' Zasedání';
        } elseif ($count >= 5) {
            $parsed = $this->countWordItService->parse($count);

            return 'Dneska už jich je '. $parsed. ' Zasedání';
        }
    }
}