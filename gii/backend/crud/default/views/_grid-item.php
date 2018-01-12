<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */
$modelClass = StringHelper::basename($generator->modelClass);
echo "<?php\n";
?>

/**
 * 不带分页的 grid 模板，常用显示子条目，例如一个订单所有订货明细
 * 与 _grid 的区别有: 
 * - dataProvider 直接通过模型的 getter (如 getItemsDataProvider()) 获取，不使用 SearchModel
 * - 用到 `footer` 显示累加金额
 * - 不使用 filter
 */

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;
use <?= ltrim($generator->modelClass, '\\') ?>;

echo GridView::widget([
    'dataProvider' => $model->itemsDataProvider,
    'showFooter' => !empty($model->itemsDataProvider->models),
    'tableOptions' => ['class' => 'table table-condenced table-striped'],
    'summary' => '',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
<?php
$tableSchema = $generator->getTableSchema();
foreach ($tableSchema->columns as $column) {
    $format = $generator->generateColumnFormat($column);
    switch ($generator->generateColumnFormat($column)) {
        case 'lookup':
            $lookupType = $generator->assembleLookupType($column);
            echo <<<LOOKUP
        [
            'attribute' => '{$column->name}',
            'filter' => Lookup::items($lookupType),
            'format' => 'raw',
            'value' => function (\$model, \$key, \$index, \$column) {
                return \$model->{$column->name};
            },
            'contentOptions' => ['style' => 'width:80px'],
        ],

LOOKUP;
            break;
        case 'decimal':
            echo <<<AMOUNT
        [
            'attribute' => '{$column->name}',
            'format' => 'decimal',
            'footer' => '', // 自行在模型中声明方法计算总数 \$model->totalQuantity,
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
                'style' => 'width:80px',
            ],
            'footerOptions' => ['class' => 'text-right text-bold'],
        ],

AMOUNT;
            break;
        case 'integer':
            echo <<<EOF
        [
            'attribute' => '{$column->name}',
            'format' => 'integer',
            'footer' => '', // 自行在模型中声明方法计算总数 \$model->totalQuantity,
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
                'style' => 'width:80px',
            ],
            'footerOptions' => ['class' => 'text-right text-bold'],
        ],

EOF;
            break;
        case 'datetime':
            echo <<<DATETIME
        [
            'attribute' => '{$column->name}',
            'format' => 'datetime',
            'filter' => Lookup::dateRangeFilter(\$searchModel, '{$column->name}'),
            'contentOptions' => ['style' => 'width:150px'],
        ],

DATETIME;
            break;
        case 'text':
            echo <<<TEXT
        '{$column->name}',

TEXT;
            break;
    }
}
?>
    ],
]); ?>
