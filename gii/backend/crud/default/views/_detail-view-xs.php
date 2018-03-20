<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>
/**
 * detail view on non-mobile device
 */

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
    if (in_array($format, ['enum', 'lookup'])) {
        $lookupType = $generator->assembleLookupType($column);
        echo <<<LOOKUP
        [
            'attribute' => '{$column->name}',
            'value' => \$model->lookup('{$column->name}'),
        ],

LOOKUP;
    } elseif (in_array($format, ['text', 'fk'])) {
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
