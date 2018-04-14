<?php

namespace drodata\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\JsExpression;
use drodata\helpers\Html;
use drodata\assets\ChartJsAsset;

/**
 * ChartJs widget
 */
class ChartJs extends Widget
{
    public $options = [];
    public $clientOptions = [];
    public $data = [];
    public $type;

    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    public function run()
    {
        echo Html::tag('canvas', '', $this->options);
        $this->registerClientScript();
    }

    protected function registerClientScript()
    {
        $id = $this->options['id'];
        $view = $this->getView();
        ChartJsAsset::register($view);
        $config = Json::encode(
            [
                'type' => $this->type,
                'data' => $this->data ?: new JsExpression('{}'),
                'options' => $this->clientOptions ?: new JsExpression('{}')
            ]
        );
        $js = ";var chartJS_{$id} = new Chart($('#{$id}'),{$config});";
        $view->registerJs($js);
    }
}
