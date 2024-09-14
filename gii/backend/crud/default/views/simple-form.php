<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */
/* @var $form yii\bootstrap\ActiveForm */

// 模型中文名称
$modelNameCn = empty($generator->modelNameCn)
    ? Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))
    : $generator->modelNameCn;
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
use kartik\select2\Select2;

$this->title = '新建';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'<?= $modelNameCn ?>' , 'url' => ['index']],
        $this->title,
    ],
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => '提示：',
            'closeButton' => false,
            'visible' => false, //Yii::$app->user->can(''),
        ], 
    ],
];

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/

?>
<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
    <?= "<?= " ?>$this->render('@drodata/views/_alert') <?= " ?>\n" ?>
    <?= "<?php " ?>Box::begin([
        'title' => $this->title,
    ]); <?= "?>\n" ?>
            <?= "<?php " ?>$form = ActiveForm::begin([
                'options' => [
                    'class' => 'prevent-duplicate-submission',
                    // 如果表单需要上传文件，去掉下面一行的注释
                    //'enctype' => 'multipart/form-data',
                ],
            ]); ?>
                <?= "<?= " ?>$this->render('@backend/views/x-item/_field-tabular-fixed', [
                    'items' => $items,
                    'form' => $form,
                ]) ?>
                <!--
                'inputTemplate' => '<div class="input-group"><div class="input-group-addon">$</div>{input}</div>'
                -->
                <?= "<?= " ?>$form->field($model, 'type')->radioList(Lookup::items('type')) ?>
                <div class="form-group">
                    <?= "<?= " ?>Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                    <?= "<?= " ?>Html::a('返回', '', ['class' => 'btn btn-default']) ?>
                </div>
            <?= "<?php " ?>ActiveForm::end(); ?>
    <?= "<?php " ?>Box::end(); ?>
    </div>
</div>
