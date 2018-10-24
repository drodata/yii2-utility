<?php

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $searchModel drodata\models\TaxonomySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* @var $isLite boolean 简化模型开关, 简化模型仅操作 name 值，不管 parent_it 列 */
$isLite = $this->context->isLite;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'name',
        [
            'attribute' => 'parent_id',
            'value' => function ($model, $key, $index, $column) {
                return $model->parent ? $model->parent->name : '';
            },
            'visible' => !$isLite,
        ],
        [
            'class' => 'drodata\grid\ActionColumn',
            'template' => '{update} {delete}',
            'contentOptions' => [
                'style' => 'min-width:120px',
                'class' => 'text-center',
            ],
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return $model->actionLink('view');
                },
            ],
        ],
    ],
]); ?>
