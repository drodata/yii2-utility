<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\bootstrap\Html;
use common\widgets\Box;
use common\models\Lookup;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params = [
    'title' => $this->title,
    'breadcrumbs' => [
        ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']],
        $this->title,
    ],
];
?>
<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <div class="col-md-12 col-lg-8 col-lg-offset-2">
        <?= "<?php " ?>Box::begin([
            'title' => $this->title,
        ]);<?= "?>\n" ?>
        <p>
            <?= "<?= " ?>Html::a(<?= $generator->generateString('修改') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
            <?= "<?= " ?>Html::a(<?= $generator->generateString('删除') ?>, ['delete', <?= $urlParams ?>], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => <?= $generator->generateString('确定删除此条目吗？') ?>,
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= "<?= " ?>DetailView::widget([
            'model' => $model,
            'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "                '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "                '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
                /*
                [
                    'attribute' => 'status',
                    'value' => Lookup::item('UserStatus', $model->status),
                ],
                */
            ],
        ]) ?>

        <?= "<?php " ?>Box::end();<?= "?>\n" ?>
    </div>
</div>
