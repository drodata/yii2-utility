<?php

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;
use drodata\models\Currency;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model drodata\models\Rate */
/* @var $form yii\bootstrap\ActiveForm */

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/
?>

<div class="rate-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'date')->staticControl(['value' => $model->date]) ?>
    <?= $form->field($model, 'currency')->staticControl(['value' => $model->currencyName]) ?>
    <?= $form->field($model, 'value')->input('number', ['step' => 0.0001, 'autoFocus' => true]) ?>

    <?= $form->field($model, 'date')->label(false)->hiddenInput() ?>
    <?= $form->field($model, 'currency')->label(false)->hiddenInput() ?>

    <?php if ($model->isNewRecord): ?>
    <?php endif; ?>
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
