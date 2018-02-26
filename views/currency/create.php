<?php

use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $model drodata\models\Currency */

$this->title = '新建货币';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'货币' , 'url' => ['index']],
        '新建',
    ],
    'alerts' => [
        [
            'options' => ['class' => 'alert-info col-md-12 col-lg-6 col-lg-offset-3'],
            'body' => "货币编码参见<a href=\"https://en.wikipedia.org/wiki/ISO_4217\" class=\"alert-link\">ISO-4217</a>",
            'closeButton' => false,
            'visible' => true, //Yii::$app->user->can(''),
        ], 
    ],
];
?>
<div class="row currency-create">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?= Box::widget([
            'content' => $this->render('_form', [
                'model' => $model,
            ]),
        ]) ?>
    </div>
</div>
