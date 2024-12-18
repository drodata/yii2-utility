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

/* @var $this yii\web\View */

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'showOnEmpty' => false,
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
        /*
        'created_at:relativeTime',
        [
            'attribute' => 'id',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->getId();
            },
            'contentOptions' => [
                'style' => 'width:100px;min-width:100px;',
            ],
        ],
        */
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
