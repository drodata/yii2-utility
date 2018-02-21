<?php

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LookupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'name',
        [
            'class' => 'drodata\grid\ActionColumn',
            'template' => '{update} {toggle-visibility}',
            'contentOptions' => [
                'style' => 'min-width:120px',
                'class' => 'text-center',
            ],
            'buttons' => [
                'toggle-visibility' => ['drodata\models\Lookup', 'toggleVisibilityButton'],
            ],
        ],
    ],
]); ?>
