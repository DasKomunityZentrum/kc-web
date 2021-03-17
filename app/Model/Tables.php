<?php
/**
 *
 * Created by PhpStorm.
 * Filename: Tables.php
 * User: Tomáš Babický
 * Date: 09.03.2021
 * Time: 23:53
 */

namespace App\Model;

/**
 * Class Tables
 *
 * @package App\Model
 */
class Tables
{
    /**
     * @var string
     */
    public const BRANCH_TABLE = 'branch';

    /**
     * @var string
     */
    public const CAR_TABLE = 'car';

    /**
     * @var string
     */
    public const CASE_TABLE = 'cause';

    /**
     * @var string
     */
    public const DEPARTMENT_TABLE = 'department';

    /**
     * @var string
     */
    public const FUNCTIONS_TABLE = 'function';

    /**
     * @var string
     */
    public const MEMBERS_TABLE = 'member';

    /**
     * @var string
     */
    public const MEETING_TABLE = 'meeting';

    /**
     * @var string
     */
    public const MEMBERS_2_FUNCTIONS_TABLE = self::MEMBERS_TABLE . '2' . self::FUNCTIONS_TABLE;

    /**
     * @var string
     */
    public const MEMBER_2_MEETING_TABLE = self::MEMBERS_TABLE . '2' . self::MEETING_TABLE;

    /**
     * @var string
     */
    public const DEPARTMENT_2_FUNCTION_TABLE = self::DEPARTMENT_TABLE . '2' . self::FUNCTIONS_TABLE;

    /**
     * @var string
     */
    public const DEPARTMENT_2_FUNCTION_2_MEMBER_TABLE = self::DEPARTMENT_TABLE . '2' . self::FUNCTIONS_TABLE . '2' . self::MEMBERS_TABLE;
}
