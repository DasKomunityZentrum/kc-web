<?php
/**
 *
 * Created by PhpStorm.
 * Filename: KCForm.php
 * User: Tomáš Babický
 * Date: 11.03.2021
 * Time: 1:36
 */

namespace App\Form;

use Nette;
use Nette\Forms\Controls;

/**
 * Class KcForm
 *
 * @package App\Form
 */
class KcForm extends \Nette\Application\UI\Form
{
    /**
     * KcForm constructor.
     *
     * @param Nette\ComponentModel\IContainer|null $parent
     * @param string|null $name
     */
    public function __construct(Nette\ComponentModel\IContainer $parent = null, string $name = null)
    {
        parent::__construct($parent, $name);

        $this->setRenderer(new KcFormRenderer());
        $this->addProtection();

        $this->onRender[] = [$this, 'makeBootstrap4'];
    }

    /**
     * @param string $name
     * @param null $caption
     *
     * @return Controls\Checkbox
     */
    public function addCheckbox(string $name, $caption = null): Controls\Checkbox
    {
        return $this[$name] = new KcCheckbox($name, $caption);
    }

    public function makeBootstrap4(): void
    {
        $renderer =  $this->getRenderer();
        $renderer->wrappers['controls']['container'] = null;
        $renderer->wrappers['pair']['container'] = 'div class="form-group row"';
        $renderer->wrappers['pair']['.error'] = 'has-danger';
        $renderer->wrappers['control']['container'] = 'div class=col-sm-9';
        $renderer->wrappers['label']['container'] = 'div class="col-sm-3 col-form-label"';
        $renderer->wrappers['control']['description'] = 'span class=form-text';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=form-control-feedback';
        $renderer->wrappers['control']['.error'] = 'is-invalid';

        foreach ($this->getControls() as $control) {
            $type = $control->getOption('type');
            if ($type === 'button') {
                $control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-secondary');
                $usedPrimary = true;

            } elseif (in_array($type, ['text', 'textarea', 'select'], true)) {
                $control->getControlPrototype()->addClass('form-control');

            } elseif ($type === 'file') {
                $control->getControlPrototype()->addClass('form-control-file');

            } elseif (in_array($type, ['checkbox', 'radio'], true)) {
                if ($control instanceof Nette\Forms\Controls\Checkbox) {
                    $control->getLabelPrototype()->addClass('form-check-label');
                } else {
                    $control->getItemLabelPrototype()->addClass('form-check-label');
                }
                $control->getControlPrototype()->addClass('form-check-input');
                $control->getSeparatorPrototype()->setName('div')->addClass('form-check');
            }
        }
    }
}
