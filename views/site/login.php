<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \drodata\models\LoginForm */

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use drodata\widgets\Box;

$this->title = '登录';
?>
<div class="row site-login">
    <div class="col-md-12 col-lg-4 col-lg-offset-4">
        <?php Box::begin([
            'title' => $this->title,
        ]);?>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        <?php Box::end();?>
    </div>
</div>
