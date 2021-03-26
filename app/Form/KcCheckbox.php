<?php
/**
 *
 * Created by PhpStorm.
 * Filename: KcCheckbox.php
 * User: Tomáš Babický
 * Date: 11.03.2021
 * Time: 1:35
 */

namespace App\Form;

use Nette\Forms\Controls\Checkbox;
use Nette\Utils\Html;

/**
 * Class KcCheckbox
 *
 * @package App\Form
 */
class KcCheckbox extends Checkbox
{
    /**
     * KcCheckbox constructor.
     *
     * @param string|null $name
     * @param string|null $caption
     */
    public function __construct($name = null, $caption = null)
    {
        parent::__construct($caption);
    }

    /**
     * @param string|null $caption
     *
     * @return Html|null
     */
    public function getLabel($caption = null)
    {
        return $this->getLabelPart();
    }
}
