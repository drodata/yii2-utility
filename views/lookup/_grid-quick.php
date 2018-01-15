<?php

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo $this->render('@drodata/views/_button');

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'name',
        [
            'class' => 'drodata\grid\ActionColumn',
            'template' => '{update}',
            'contentOptions' => [
                'style' => 'min-width:120px',
                'class' => 'text-center',
            ],
        ],
    ],
]); ?>
