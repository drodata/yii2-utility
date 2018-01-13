<?php

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Lookup */
/* @var $name string 名称 */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="purchase-form">
    <?php $form = ActiveForm::begin(['id' => 'lookup-quick-create-form']); ?>
    <?= $form->field($model, 'name')->label($label)->textInput(['autoFocus' => true]) ?>
    <?= $form->field($model, 'type')->label(false)->hiddenInput() ?>
    <?= $form->field($model, 'code')->label(false)->hiddenInput() ?>
    <?= $form->field($model, 'position')->label(false)->hiddenInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '保存', [
            'class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'),
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
