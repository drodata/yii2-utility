<?php

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\models\User;
use kartik\select2\Select2;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model drodata\models\User */
/* @var $common drodata\models\CommonForm */
/* @var $form yii\bootstrap\ActiveForm */

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/
?>

<?= $this->render('@drodata/views/_alert') ?>

<div class="user-form">
    <?php $form = ActiveForm::begin([
        // 如果表单需要上传文件，去掉下面一行的注释
        // 'options' => ['enctype' => 'multipart/form-data'],
        // 如果表单需要通过 AJAX 提交，去掉下面两行的注释
        // 'id' => 'user-form',
        // 'action' => 'ajax-submit',
    ]); ?>

    <?php if ($model->isNewRecord): ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($common, 'password')->passwordInput(['placeholder' => '至少6个字符']) ?>
    <?= $form->field($common, 'passwordRepeat')->passwordInput() ?>
    <?php endif; ?>

    <?php if (!$model->isNewRecord): ?>
    <?= $form->field($model, 'username')->staticControl() ?>
    <?php endif; ?>

    <?= $form->field($common, 'roles')->inline()->checkboxList(User::roleList()) ?>
    <?= $form->field($model, 'mobile_phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->input('email') ?>
    <?= $form->field($model, 'status')->inline()->radioList(Lookup::items('user-status')) ?>

    <?php
    /**
    echo $form->field($model, 'id')->label(false)->hiddenInput();
    if ($model->isNewRecord) {
        echo $form->field($common, 'images[]')->fileInput(['multiple' => true]);
    }
    echo $this->render('_field', [
        'form' => $form,
        'model' => $model,
        'common' => $common,
    ]);
     */
    ?>
    <div class="row">
        <div class="col-lg-6 col-md-12">
        </div>
        <div class="col-lg-6 col-md-12">
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '保存', [
            'class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'),
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
