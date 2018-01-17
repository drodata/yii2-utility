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
            'template' => '{update} {toggle-visibility}',
            'contentOptions' => [
                'style' => 'min-width:120px',
                'class' => 'text-center',
            ],
            'buttons' => [
                'toggle-visibility' => function ($url, $model, $key) {
                    return Html::actionLink(
                        $url,
                        [
                            'title' => $model->visible ? '隐藏' : '显示',
                            'icon' => $model->visible ? 'toggle-on' : 'toggle-off',
                            'color' => 'danger',
                            'data' => [
                                'method' => 'post',
                            ],
                        ]
                    );
                },
            ],
        ],
    ],
]); ?>
