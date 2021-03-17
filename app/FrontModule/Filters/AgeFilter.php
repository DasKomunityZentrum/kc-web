<?php
/**
 *
 * Created by PhpStorm.
 * Filename: AgeFilter.php
 * User: Tomáš Babický
 * Date: 15.03.2021
 * Time: 0:27
 */

namespace App\FrontModule\Filters;

use App\Model\Entities\MemberEntity;
use Nette\Utils\DateTime;

/**
 * Class AgeFilter
 *
 * @package App\Filters
 */
class AgeFilter
{
    /**
     * @param MemberEntity $memberEntity
     *
     * @return string
     */
    public function __invoke(MemberEntity $memberEntity): string
    {
        if ($memberEntity->gender === 'm') {
            if ($memberEntity->birthYear === null) {
                $vars = ['X', 'Y', 'Z'];

                $age = '';

                for ($i = 0; $i < 3; $i++) {
                    $age .= $vars[random_int(0,2)];
                }

                return $age . ' :P';
            } else {
                $nowYear = new DateTime();
                $birthYear = new DateTime();
                $birthYear->setDate($memberEntity->birthYear, null, null);

                return sprintf('~%d', $nowYear->diff($birthYear)->y);
            }
        } elseif ($memberEntity->gender === 'f') {
            if ($memberEntity->birthYear === null) {
                return sprintf('~%d', random_int(18, 25));
            } else {
                $nowYear = new DateTime();
                $birthYear = new DateTime();
                $birthYear->setDate($memberEntity->birthYear, null, null);

                $age = $nowYear->diff($birthYear)->y;

                $moduleAge = $age % 10;

                $ccaAgeFirst = $age - $moduleAge;
                $ccaAgeSecond = $ccaAgeFirst + 10;

                return sprintf('%d - %d', $ccaAgeFirst, $ccaAgeSecond);
            }
        }
    }
}
