<?php

use drodata\helpers\Html;
use drodata\widgets\Box;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model drodata\models\User */
/* @var $common backend\models\CommonForm */
?>
<div class="row">
    <div class="col-lg-12">
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-lg-12">
    </div>
</div>
