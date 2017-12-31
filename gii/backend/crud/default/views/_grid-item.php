<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

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
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "        '" . $name . "',\n";
        } else {
            echo "        // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "        '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "        // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
        /*
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
            'contentOptions' => ['style' => 'width:150px'],
        ],
        [
            'attribute' => 'amount',
            'format' => 'decimal',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
                'style' => 'width:80px',
            ],
            'footerOptions' => ['class' => 'text-right text-bold'],
            'footer' => $model->itemsSum,
            'visible' => true, // Yii::$app->user->can('');
        ],
        [
            'attribute' => 'status',
            'filter' => Lookup::items('UserStatus'),
            'value' => function ($model, $key, $index, $column) {
                return Lookup::item('UserStatus', $model->status);
            },
            'contentOptions' => ['style' => 'width:80px'],
        ],
        */
    ],
]); ?>
