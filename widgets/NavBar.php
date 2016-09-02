<?php

namespace drodata\widgets;

use Yii;
use drodata\helpers\Html;

class NavBar extends \yii\bootstrap\NavBar
{
    /**
     * Fix the problem that the toggle button
     * is missing in AdminLTE.
     *
     * @return string the rendering toggle button.
     */
    protected function renderToggleButton()
    {
        $bar = Html::icon('bars');
        $screenReader = "<span class=\"sr-only\">{$this->screenReaderToggleText}</span>";
        return Html::button("{$screenReader}\n{$bar}", [
            'class' => 'navbar-toggle',
            'data-toggle' => 'collapse',
            'data-target' => "#{$this->containerOptions['id']}",
        ]);
    }
}

