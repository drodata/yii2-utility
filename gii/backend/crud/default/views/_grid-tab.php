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

/**
 * 用在首页 Tabs widget 内，用来实现“待办事项”
 */
use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
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
            'contentOptions' => ['style' => 'width:80px'],
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
            'contentOptions' => ['style' => 'width:80px'],
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
                'style' => 'width:80px',
            ],
        ],

AMOUNT;
                break;
            case 'integer':
                echo <<<EOF
        [
            'attribute' => '{$column->name}',
            'format' => 'integer',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => [
                'class' => 'text-right',
                'style' => 'width:80px',
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
            'contentOptions' => ['style' => 'width:150px'],
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
            'template' => '{view}',
            'contentOptions' => [
                'style' => 'min-width:60px',
            ],
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return $model->actionLink('view');
                },
            ],
        ],
    ],
]); ?>
