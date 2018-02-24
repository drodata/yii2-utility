<?php

use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $model drodata\models\User */
/* @var $common drodata\models\CommonForm */

$this->title = '修改用户';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'用户' , 'url' => ['index']],
    ],
    /*
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => 'hello',
            'closeButton' => false,
            'visible' => true, //Yii::$app->user->can(''),
        ], 
    ],
    */
];
?>
<div class=row "user-update">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?= Box::widget([
            'content' => $this->render('_form', [
                'model' => $model,
                'common' => $common,
            ]),
        ]) ?>
    </div>
</div>
