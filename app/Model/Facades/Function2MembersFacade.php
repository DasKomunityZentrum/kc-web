<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Function2MembersFacade.php
 * User: Tomáš Babický
 * Date: 17.03.2021
 * Time: 22:19
 */

namespace App\Model\Facades;

use App\Model\Entities\FunctionEntity;
use App\Model\Entities\Member2FunctionEntity;

/**
 * Class Function2MembersFacade
 *
 * @package App\Model\Facades
 */
class Function2MembersFacade
{
    /**
     * @var Member2FunctionFacade $member2FunctionFacade
     */
    private Member2FunctionFacade $member2FunctionFacade;

    /**
     * Function2MembersFacade constructor.
     *
     * @param Member2FunctionFacade $member2FunctionFacade
     */
    public function __construct(Member2FunctionFacade $member2FunctionFacade)
    {
        $this->member2FunctionFacade = $member2FunctionFacade;
    }

    /**
     * @param Member2FunctionEntity[] $member2Functions
     *
     * @return FunctionEntity[]
     */
    public function join(array $member2Functions): array
    {
        $functions = [];

        foreach ($member2Functions as $member2Function) {
            $member2Function->functionEntity->members = [];

            $functions[$member2Function->functionEntity->id] = $member2Function->functionEntity;
        }

        foreach ($member2Functions as $function) {
            $functions[$function->functionEntity->id]->members[$function->memberEntity->id] = $function->memberEntity;
        }

        return $functions;
    }

    public function getByFunctionId($functionId)
    {
        $function2Members = $this->member2FunctionFacade->getByRight($functionId);

        return $this->join($function2Members)[0];
    }

    public function getAll()
    {
        $functions2Members = $this->member2FunctionFacade->getAll();

        return $this->join($functions2Members);
    }
}
