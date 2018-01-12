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

<?= "echo " ?>DetailView::widget([
    'model' => $model,
    'attributes' => [
<?php
foreach ($generator->getTableSchema()->columns as $column) {
    $format = $generator->generateColumnFormat($column);
    if ($format == 'lookup') {
        $lookupType = $generator->assembleLookupType($column);
        echo <<<LOOKUP
        [
            'attribute' => '{$column->name}',
            'value' => Lookup::item('$lookupType', \$model->{$column->name});
        ],

LOOKUP;
    } elseif ($format == 'text') {
        echo <<<NORMAL
        '{$column->name}',

NORMAL;
    } else {
        echo <<<NORMAL
        '{$column->name}:$format',

NORMAL;
    }
}
?>
        /*
        [
            'label' => '明细',
            'format' => 'raw',
            'value' => $this->render('_grid-item', ['model' => $model]),
        ],
        */
    ],
]);
