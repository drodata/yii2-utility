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
 * 单独上传文件视图
 */

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

$this->title = '上传附件';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'<?= $modelNameCn ?>' , 'url' => ['index']],
        $this->title,
    ],
    /*
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => 'hello',
            'closeButton' => false,
            'visible' => true, //Yii::$app->user->can(''),
        ], 
    ],
    */
];

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/

?>
<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-upload-form">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?= "<?php " ?>Box::begin([
        ]); <?= "?>\n" ?>
            <?= "<?= " ?>$this->render('@drodata/views/_alert')<?= " ?>\n" ?>

            <?= "<?php " ?>$form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>
                <?= "<?= " ?>$form->field($common, 'images[]')->fileInput(['multiple' => true])<?= " ?>\n" ?>
                <div class="form-group">
                    <?= "<?= " ?>Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                </div>
            <?= "<?php " ?>ActiveForm::end(); ?>
        <?= "<?php " ?>Box::end(); ?>
    </div>
</div>
