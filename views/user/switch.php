<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \drodata\models\CommonForm */
/* @var $map array user map (id => username) */

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use drodata\widgets\Box;

$this->title = '切换用户';
?>
<div class="row">
    <div class="col-md-12 col-lg-4 col-lg-offset-4">
        <?php Box::begin([
            'title' => $this->title,
        ]);?>
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'user_id')->dropDownList($map) ?>
                <div class="form-group">
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        <?php Box::end();?>
    </div>
</div>
