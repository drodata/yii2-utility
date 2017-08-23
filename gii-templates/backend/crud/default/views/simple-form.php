<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */
/* @var $form yii\bootstrap\ActiveForm */

echo "<?php\n";
?>

/**
 * 与 create.php 中将 _form 独立出来不同，此视图直接使用表单，用于一些简单的操作
 */

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

$this->title = '新建';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']],
        $this->title,
    ],
];

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/

?>
<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <div class="col-md-12 col-lg-6">
        <?= "<?php " ?>Box::begin([
            'title' => $this->title,
        ]); <?= "?>\n" ?>
            <?= "<?php " ?>$form = ActiveForm::begin(); ?>
                <!--
                'inputTemplate' => '<div class="input-group"><div class="input-group-addon">$</div>{input}</div>'
                echo $form->field($model, 'type')->radioList(Lookup::items('AdjustType'));
                -->
                <div class="form-group">
                    <?= "<?= " ?>Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                </div>
            <?= "<?php " ?>ActiveForm::end(); ?>
        <?= "<?php " ?>Box::end(); ?>
    </div>
</div>
