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

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/**
 * 借助 'caption' 属性显示筛选数据累计金额
if (empty(Yii::$app->request->get('<?= $searchModelClass ?>'))) {
    $caption = '';
} else {
    $sum = (int) $dataProvider->query->sum('amount');;
    $badge = Html::tag('span', Yii::$app->formatter->asDecimal($sum), [
        'class' => 'badge',
    ]);
    $caption = Html::tag('p', "筛选累计 $badge");
}
 */
echo GridView::widget([
    'dataProvider' => $dataProvider,
    // 'caption' => $caption,
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
        $lookupType = $generator->assembleLookupType($column);
        switch ($generator->generateColumnFormat($column)) {
            case 'enum':
                echo <<<ENUM
        [
            'attribute' => '{$column->name}',
            'filter' => Lookup::items('$lookupType'),
            'format' => 'raw',
            'value' => function (\$model, \$key, \$index, \$column) {
                return \$model->lookup('{$column->name}');
            },
        ],

ENUM;
                break;
            case 'lookup':
                echo <<<LOOKUP
        [
            'attribute' => '{$column->name}',
            'filter' => Lookup::items('$lookupType'),
            'format' => 'raw',
            'value' => function (\$model, \$key, \$index, \$column) {
                return \$model->lookup('{$column->name}');
            },
        ],

LOOKUP;
                break;
            case 'decimal':
                echo <<<AMOUNT
        [
            'attribute' => '{$column->name}',
            'format' => 'decimal',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
            ],
        ],

AMOUNT;
                break;
            case 'integer':
                echo <<<EOF
        [
            'attribute' => '{$column->name}',
            'format' => 'integer',
            'value' => function (\$model, \$key, \$index, \$column) {
                return \$model->{$column->name};
            },
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
            ],
        ],

EOF;
                break;
            case 'datetime':
                echo <<<DATETIME
        [
            'attribute' => '{$column->name}',
            'format' => 'datetime',
            'filter' => Lookup::dateRangeFilter(\$searchModel, '{$column->name}'),
        ],

DATETIME;
                break;
            default:
                echo <<<TEXT
        '{$column->name}',

TEXT;
                break;
        }
    }
}
?>
        [
            'class' => 'drodata\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'contentOptions' => [
                'style' => 'min-width:120px',
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
