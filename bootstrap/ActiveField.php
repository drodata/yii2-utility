<?php

namespace drodata\bootstrap;

use drodata\helpers\Html;

/**
 * Feature:
 * 
 * - Bootstrap popover style hint
 *
 */

class ActiveField extends \yii\bootstrap\ActiveField 
{

    /**
     * the `{hint}` placeholder could generate a font-awesome style popover.
     */
    public $template = "{label} {hint}\n{input}\n{error}";
    public $inlineCheckboxListTemplate = "{label} {hint}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}";
    public $inlineRadioListTemplate = "{label} {hint}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}";

    /**
     * Generate a Bootstrap Popover style hint
     */
    public function hint($content, $options = [])
    {
        if ($content === false) {
            $this->parts['{hint}'] = '';
            return $this;
        }
        $options = array_merge($this->hintOptions, $options);
        if ($content !== null) {
            $options['hint'] = $content;
        }

        $hintContent = $this->model->getAttributeHint($this->attribute);

        $this->parts['{hint}'] = empty($hintContent) ? '' : Html::icon('question-circle-o', [
            'class' => 'text-info',
            'data' => [
                'toggle' => 'popover',
                'html' => true,
                'placement' => 'auto top',
                'trigger' => 'hover',
                'title' => '',
                'content' => $hintContent,
            ],
        ]);
        return $this;
    }
}
