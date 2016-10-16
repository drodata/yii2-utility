<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? "use yii\widgets\Pjax;\n" : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params = [
    'title' => $this->title,
    'breadcrumbs' => [
        ['label' => $this->title, 'url' => 'index'],
        '管理',
    ],
];
?>
<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <div class="col-sm-12">
<?php if(!empty($generator->searchModelClass)): ?>
<?php endif; ?>
        <?= "<?php " ?>Box::begin([
            'title' => $this->title,
            'tools' => [
                Html::a(<?= $generator->generateString('新建' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-sm btn-success'])
            ],
        ]);<?= "?>\n" ?>
<?= $generator->enablePjax ? "            <?php Pjax::begin(); ?>\n" : '' ?>
<?php if ($generator->indexWidgetType === 'grid'): ?>
            <?= "<?= " ?>GridView::widget([
                'dataProvider' => $dataProvider,
                /* `afterRow` has the same signature
                'rowOptions' => function ($model, $key, $index, $grid) {
                     return [
                         'class' => ($model->status == Product::DISABLED) ? 'bg-danger' : '',
                     ];
                },
                */
                <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n               'columns' => [\n" : "'columns' => [\n"; ?>
                    ['class' => 'yii\grid\SerialColumn'],
<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "                    '" . $name . "',\n";
        } else {
            echo "                    // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "                    '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "                    // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

                    /*
                    [
                        'attribute' => 'status',
                        'filter' => Lookup::items('UserStatus'),
                        'value' => function ($model, $key, $index, $column) {
                            return Lookup::item('UserStatus', $model->status);
                        },
                        'contentOptions' => ['width' => '80px'],
                    ],
                    [
                        'label' => '',
                        'format' => 'raw',
                        'value' => function ($model, $key, $index, $column) {
                            return $model->rolesString;
                        },
                    ],
                    */
                    ['class' => 'drodata\grid\ActionColumn'],
                    /*
                    [
                        'class' => 'drodata\grid\ActionColumn',
                        'template' => '{view} {update} {delete} {}',
                        'buttons' => [
                            '' => function ($url, $model, $key) {
                                return Html::a(Html::icon(''), ['/order/view', 'id' => $model->id],[
                                    'title' => '',
                                    'data' => [
                                        'id' => $model->id,
                                    ],
                                ]);
                            },
                        ],
                    ],
                    */
                ],
            ]); ?>
<?php else: ?>
            <?= "<?= " ?>ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'row'],
                'itemOptions' => ['class' => 'col-sm-12 col-md-6 col-lg-4'],
                'summaryOptions' => ['class' => 'col-xs-12'],
                'itemView' => '_list-view',
            ]) ?>
<?php endif; ?>
<?= $generator->enablePjax ? "            <?php Pjax::end(); ?>\n" : '' ?>
        <?= "<?php " ?>Box::end();<?= "?>\n" ?>
    </div>
</div> <!-- .row -->
