<?php

/**
 * 视图中常用的提示信息区域。通过设置 `alerts` 属性完成。
 * `alerts` 是一个数组，数组中的元素是 `yii\bootstrap\Alert` widget 的配置数组，
 * 此外，以下特殊的属性可用：
 *
 * - `visible`: 控制 Alert widget 的可见性
 * 
 * ```xml
 * <?php
 * $this->params = [
 *     'alerts' => [
 *         [
 *             'options' => ['class' => 'alert-info'],
 *             'body' => '你好',
 *         ],
 *         [
 *             'options' => ['class' => 'alert-warning'],
 *             'body' => '通过设置 visible 属性可以控制 Alert 的可见行.',
 *             'visible' => Yii::$app->user->can('saler'),
 *         ],
 *     ],
 *     // ...
 * ];
 * ?>
 * 
 * <div class="col-xs-12">
 *     <?= $this->render('@drodata/views/_alert') ?>
 * </div>
 * ```
 */ 

use yii\helpers\ArrayHelper;
use drodata\helpers\Html;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */

if(!empty($this->params['alerts'])) {
    echo Html::beginTag('div', ['class' => 'row']);
    foreach($this->params['alerts'] as $configParams) {
        $visible = ArrayHelper::remove($configParams, 'visible', true);

        if ($visible) {
            echo Html::beginTag('div', ['class' => 'col-xs-12'])
                . Alert::widget($configParams)
                . Html::endTag('div');
        }
    }
    echo Html::endTag('div');
}
