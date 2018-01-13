<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use common\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Lookup */
/* @var $form yii\widgets\ActiveForm */

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/
?>

<div class="lookup-form">

    <?php $form = ActiveForm::begin(); ?>
        <!--
        <div class="row">
            <div class="col-lg-6 col-md-12">
            </div>
        </div>

        'inputTemplate' => '<div class="input-group"><div class="input-group-addon">$</div>{input}</div>'
        -->
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <?= $form->field($model, 'visible')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '保存', [
            'class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary') . ' submit-once',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
