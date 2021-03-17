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

class KcCheckbox extends \Nette\Forms\Controls\Checkbox
{
    public function __construct($name = null, $caption = null)
    {
        parent::__construct($caption);
    }

    public function getLabel($caption = null)
    {
        return $this->getLabelPart();
    }
}