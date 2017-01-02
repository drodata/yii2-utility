<?php

namespace drodata\bootstrap;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Button;

/**
 * The problem of original ButtonDropdown class is:
 * when used in split mode, both the main button and dropdown
 * button use the same options, what I want to implement is that
 * the main button could have some additional classes that
 * could be used for triggering ajax request. That is why
 * I created this class, the new added `$mainButtonClass`
 * is used for storing these additional classes.
 *
 *
 */

class ButtonDropdown extends \yii\bootstrap\ButtonDropdown
{
    public $buttonOptions = [];

    /**
     * Generates the button dropdown.
     * @return string the rendering result.
     */
    protected function renderButton()
    {
        Html::addCssClass($this->options, ['widget' => 'btn']);
        $label = $this->label;
        if ($this->encodeLabel) {
            $label = Html::encode($label);
        }
        if ($this->split) {
            $options = $this->buttonOptions;
            $this->options['data-toggle'] = 'dropdown';
            Html::addCssClass($this->options, ['toggle' => 'dropdown-toggle']);
            unset($this->options['id']);
            $splitButton = Button::widget([
                'label' => '<span class="caret"></span>',
                'encodeLabel' => false,
                'options' => $this->options,
                'view' => $this->getView(),
            ]);
        } else {
            $label .= ' <span class="caret"></span>';
            $options = $this->options;
            if (!isset($options['href']) && $this->tagName === 'a') {
                $options['href'] = '#';
            }
            Html::addCssClass($options, ['toggle' => 'dropdown-toggle']);
            $options['data-toggle'] = 'dropdown';
            $splitButton = '';
        }
        return Button::widget([
            'tagName' => $this->tagName,
            'label' => $label,
            'options' => $options,
            'encodeLabel' => false,
            'view' => $this->getView(),
        ]) . "\n" . $splitButton;
    }
}
