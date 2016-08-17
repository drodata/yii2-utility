<?php

namespace drodata\widgets;
use Yii;
use yii\helpers\Html;
use yii\bootstrap\BaseHtml;

class InfoBox extends \yii\bootstrap\Widget
{
    public $style;
    public $icon;
    public $text;
    public $number;
    public $operation = '';
    public $roles = [];

    public function init()
    {
        parent::init();
        
        if (count($this->roles) == 0 || Yii::$app->user->identity->in($this->roles)) {

            $opt  = Html::beginTag('div', ['class' => 'col-md-3 col-sm-6 col-xs-12']);
            $opt  .= Html::beginTag('div', ['class' => 'info-box']);
        
            // icon
            $opt  .= Html::tag(
                'span',
                BaseHtml::icon($this->icon),
                ['class' => 'info-box-icon bg-' . $this->style]
            );
            // content
            $opt  .= Html::beginTag('div', ['class' => 'info-box-content']);
            $opt  .= Html::tag(
                'span',
                $this->text,
                ['class' => 'info-box-text']
            );
            $opt  .= Html::tag(
                'span',
                $this->number,
                ['class' => 'info-box-number']
            );
            $opt  .= Html::tag(
                'div',
                $this->operation,
                ['class' => 'info-box-operation text-right']
            );
            $opt  .= Html::endTag('div'); // info-box-content
        
            echo $opt;
        }
    }
    public function run()
    {
        if (count($this->roles) == 0 || Yii::$app->user->identity->in($this->roles)) {
            echo Html::endTag('div')  // .info-box 
            . Html::endTag('div'); // .col-*
        }
    }
}
