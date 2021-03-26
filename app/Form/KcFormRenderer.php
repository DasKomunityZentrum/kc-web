<?php
/**
 *
 * Created by PhpStorm.
 * Filename: KcFormRenderer.php
 * User: Tomáš Babický
 * Date: 11.03.2021
 * Time: 1:10
 */

namespace App\Form;

use Nette\Forms\Control;
use Nette\Forms\Controls\BaseControl;
use Nette\Forms\Controls\Checkbox;
use Nette\Forms\Rendering\DefaultFormRenderer;
use Nette\HtmlStringable;
use Nette\Utils\Html;

/**
 * Class KcFormRenderer
 *
 * @package App\Form
 */
class KcFormRenderer extends DefaultFormRenderer
{
    /**
     * @param Control $control
     *
     * @return Html
     */
    public function renderControl(Control $control) : Html
    {
        $body = $this->getWrapper('control container');
        if ($this->counter % 2) {
            $body->class($this->getValue('control .odd'), true);
        }
        if (!$this->getWrapper('pair container')->getName()) {
            $body->class($control->getOption('class'), true);
            $body->id = $control->getOption('id');
        }

        $description = $control->getOption('description');
        if ($description instanceof HtmlStringable) {
            $description = ' ' . $description;

        } elseif ($description != null) { // intentionally ==
            if ($control instanceof BaseControl) {
                $description = $control->translate($description);
            }
            $description = ' ' . $this->getWrapper('control description')->setText($description);

        } else {
            $description = '';
        }

        if ($control->isRequired()) {
            $description = $this->getValue('control requiredsuffix') . $description;
        }

        $els = $errors = [];
        renderControl:
        $control->setOption('rendered', true);

        // KC Improvement, we want render label at left
        // Is this an instance of a Checkbox?
        if ($control instanceof Checkbox) {
            $el = $control->getControlPart();
        } else {
            $el = $control->getControl();
        }

        if ($el instanceof Html) {
            if ($el->getName() === 'input') {
                $el->class($this->getValue("control .$el->type"), true);
            }
            $el->class($this->getValue('control .error'), $control->hasErrors());
        }
        $els[] = $el;
        $errors = array_merge($errors, $control->getErrors());

        if ($nextTo = $control->getOption('nextTo')) {
            $control = $control->getForm()->getComponent($nextTo);
            $body->class($this->getValue('control .multi'), true);
            goto renderControl;
        }

        return $body->setHtml(implode('', $els) . $description . $this->doRenderErrors($errors, true));
    }

    private function doRenderErrors(array $errors, bool $control): string
    {
        if (!$errors) {
            return '';
        }
        $container = $this->getWrapper($control ? 'control errorcontainer' : 'error container');
        $item = $this->getWrapper($control ? 'control erroritem' : 'error item');

        foreach ($errors as $error) {
            $item = clone $item;
            if ($error instanceof HtmlStringable) {
                $item->addHtml($error);
            } else {
                $item->setText($error);
            }
            $container->addHtml($item);
        }

        return $control
            ? "\n\t" . $container->render()
            : "\n" . $container->render(0);
    }
}
