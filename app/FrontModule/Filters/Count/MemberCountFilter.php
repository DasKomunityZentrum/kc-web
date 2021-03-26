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
         if ($count === 0) {
             return 'Bohužel, ještě žádnoé Zasedání nemáme';
         } elseif ($count === 1) {
             return 'Dneska už máme jedno Zasedání!';
         } elseif ($count < 5) {
             $parsed = $this->countWordHeService->parse($count);

             return 'Dneska už jsou ' . $parsed . ' Zasedání';
         } elseif ($count >= 5) {
             $parsed = $this->countWordHeService->parse($count);

             return 'Dneska už jich je '. $parsed. ' Zasedání';
         }
    }
}
