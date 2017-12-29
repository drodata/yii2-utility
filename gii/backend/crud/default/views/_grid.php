<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$searchModelClass = StringHelper::basename($generator->searchModelClass);

echo "<?php\n";
?>

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

/**
 * 借助 'caption' 属性显示筛选数据累计金额
if (empty(Yii::$app->request->get('<?= $searchModelClass ?>'))) {
    $caption = '';
} else {
    $sum = 0;
    foreach ($dataProvider->models as $model) {
        $sum += $model->amount;
    }
    $badge = Html::tag('span', Yii::$app->formatter->asDecimal($sum), [
        'class' => 'badge',
    ]);
    $caption = Html::tag('p', "金额累计 $badge");
}
 */
echo GridView::widget([
    'dataProvider' => $dataProvider,
    /* `afterRow` has the same signature
    'rowOptions' => function ($model, $key, $index, $grid) {
        return [
            'class' => ($model->status == Product::DISABLED) ? 'bg-danger' : '',
        ];
    },
    */
<?= !empty($generator->searchModelClass) ? "    'filterModel' => \$searchModel,\n    'columns' => [\n" : "    'columns' => [\n"; ?>
        // ['class' => 'yii\grid\SerialColumn'],
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
            'filter' => Lookup::dateRangeFilter($searchModel, 'created_at'),
        ],
        [
            'attribute' => 'amount',
            'format' => 'decimal',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
                'style' => 'width:80px',
            ],
        ],
        [
            'attribute' => 'status',
            'filter' => Lookup::items('UserStatus'),
            'value' => function ($model, $key, $index, $column) {
                return Lookup::item('UserStatus', $model->status);
            },
            'contentOptions' => ['style' => 'width:80px'],
        ],
        [
            'label' => '',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->rolesString;
            },
        ],
        */
        [
            'class' => 'drodata\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'contentOptions' => [
                'style' => 'min-width:120px',
                'class' => 'text-center',
            ],
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return $model->actionLink('view');
                },
                'update' => function ($url, $model, $key) {
                    return $model->actionLink('update');
                },
                'delete' => function ($url, $model, $key) {
                    return $model->actionLink('delete');
                },
            ],
        ],
    ],
]); ?>
