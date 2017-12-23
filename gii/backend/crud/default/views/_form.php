<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
        <!--
        <div class="row">
            <div class="col-lg-6 col-md-12">
            </div>
        </div>

        'inputTemplate' => '<div class="input-group"><div class="input-group-addon">$</div>{input}</div>'

        dropDownList(Lookup::items(''), ['prompt' => ''])
        inline()->radioList(Lookup::items(''))
        textArea(['rows' => 3])
        input('number', ['step' => 0.01]);
        widget(Select2::classname(), [
            'data' => Lookup::items('AcceptanceSource'),
            'options' => ['placeholder' => '请选择'],
            'addon' => [
            ],
        ])
        staticControl()
        -->
<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('新建') ?> : <?= $generator->generateString('保存') ?>, [
            'class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'),
        ]) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
