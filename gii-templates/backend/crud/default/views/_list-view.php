<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\widgets\DetailView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

Box::begin([
    'title' => 'Detail',
    'footer' => $this->render('_list-action', ['model' => $model]),
]);

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        /*
        [
            'attribute' => 'product_id',
            'value' => $model->product->size,
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => $model->readableStatus,
        ],
        */
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "        '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "        '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
    ],
]);

Box::end();
