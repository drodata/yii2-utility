<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>
use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

?>
    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
            /*
            [
                'label' => '明细',
                'format' => 'raw',
                'value' => $this->render('_grid-item', ['model' => $model]),
            ],
            [
                'attribute' => 'status',
                // 根据需要更改 'Status' 值
                'value' => $model->lookup('Status', $model->status),
            ],
            [
                'attribute' => 'created_by',
                'value' => $model->readableCreator,
            ],
            */
        ],
    ]) ?>
