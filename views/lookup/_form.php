<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use common\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Lookup */
/* @var $form yii\widgets\ActiveForm */
/* @var $label string 中文名称 */

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/
?>

<div class="lookup-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->label($label . '名称')->textInput(['autoFocus' => true]) ?>
    <?= $form->field($model, 'type')->label(false)->hiddenInput() ?>
    <?= $form->field($model, 'code')->label(false)->hiddenInput() ?>
    <?= $form->field($model, 'position')->label(false)->hiddenInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '保存', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
