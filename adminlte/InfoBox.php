<?php

namespace drodata\adminlte;
use Yii;
use drodata\helpers\Html;

/**
 * Sample:
 *
 * echo \drodata\adminlte\InfoBox::widget([
 *     'style' => 'default',
 *     'icon' => 'dollar',
 *     'text' => 'This',
 *     'number' => '4455',
 *     'visible' => false,
 * ]);
 *
 * @since 1.0.16
 */
class InfoBox extends \yii\bootstrap\Widget
{
    public $style;
    public $icon;
    public $text;
    public $number;
    public $operation = '';
    public $roles = [];
    public $visible = true;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if (!$this->visible) {
            return '';
        } 

        return <<<CONTENT
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-{$this->style}">
            <i class="fa fa-{$this->icon}"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">{$this->text}</span>
            <span class="info-box-number">{$this->number}</span>
            <div class="info-box-operation text-right">{$this->operation}</div>
        </div>
    </div>
</div>
CONTENT;
    }
}
