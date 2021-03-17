<?php
/**
 *
 * Created by PhpStorm.
 * Filename: NickFilter.php
 * User: Tomáš Babický
 * Date: 15.03.2021
 * Time: 1:08
 */

namespace App\FrontModule\Filters;

use App\Model\Entities\MemberEntity;

/**
 * Class NickFilter
 *
 * @package App\Filters
 */
class NickFilter
{
    /**
     * @param MemberEntity $memberEntity
     *
     * @return mixed|string
     */
    public function __invoke(MemberEntity $memberEntity) : string
    {
        $nickSentence = '';

        $nicks = explode(';', $memberEntity->nick);
        $nicksCount = count($nicks);

        if ($memberEntity->nick) {
            if ($memberEntity->gender === 'm') {
                $nickSentence .= 'Kámoši';

                if ($memberEntity->active) {
                    $nickSentence .=  ' mi říkají';
                } else {
                    $nickSentence .= ' mi říkali';
                }

            } elseif ($memberEntity->gender === 'f') {
                $nickSentence .= 'Kámošky';

                if ($memberEntity->active) {
                    $nickSentence .=  ' mi říkají';
                } else {
                    $nickSentence .= ' mi říkaly';
                }
            }

            if ($nicksCount > 1) {
                $nickSentence .= ' třeba';
            }

            $nickSentence .= ' ' . $nicks[random_int(0, $nicksCount - 1)] .  '.';
        } else {
            $nickSentence.= 'Zřejmě nemám';

            if ($memberEntity->gender === 'm') {
                $nickSentence .= ' kámoše, pač mi nikdo ';

                if ($memberEntity->active) {
                    $nickSentence .=  'neříká ';
                } else {
                    $nickSentence .= 'neříkal ';
                }

            } elseif ($memberEntity->gender === 'f') {
                $nickSentence .= ' kámošky, pač mi';

                if ($memberEntity->active) {
                    $nickSentence .=  ' žádná neříká';
                } else {
                    $nickSentence .= ' žádný neříkaly';
                }
            }

            $nickSentence .= ' přezdívkou.';
        }

        return $nickSentence;
    }
}
