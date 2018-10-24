<?php

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model drodata\models\Taxonomy */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $hideParent bool 是否隐藏 parent_id 元素 */
?>

<?= $this->render('@drodata/views/_alert') ?>

<div class="taxonomy-form">
    <?php $form = ActiveForm::begin([
        'id' => 'taxonomy-form',
    ]); ?>
    <?= $form->field($model, 'id')->label(false)->hiddenInput() ?>
    <?= $form->field($model, 'type')->label(false)->hiddenInput() ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php 
    echo $hideParent ?  $form->field($model, 'parent_id')->label(false)->hiddenInput()
        : $form->field($model, 'parent_id')->dropDownList(['' => '根目录'] + Lookup::taxonomies($this->context->id));
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '保存', [
            'class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'),
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
