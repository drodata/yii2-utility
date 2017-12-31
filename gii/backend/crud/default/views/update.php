<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
// 模型中文名称
$modelNameCn = empty($generator->modelNameCn)
    ? Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))
    : $generator->modelNameCn;

echo "<?php\n";
?>

use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = '修改<?= $modelNameCn ?>';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'<?= $modelNameCn ?>' , 'url' => ['index']],
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
?>
<div class=row "<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?= "<?= " ?>Box::widget([
            'content' => $this->render('_form', [
                'model' => $model,
            ]),
        ]) <?= "?>\n" ?>
    </div>
</div>
