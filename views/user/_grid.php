<?php

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $searchModel drodata\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/**
 * 借助 'caption' 属性显示筛选数据累计金额
if (empty(Yii::$app->request->get('UserSearch'))) {
    $caption = '';
} else {
    $sum = 0;
    foreach ($dataProvider->models as $model) {
        $sum += $model->amount;
    }
    $badge = Html::tag('span', Yii::$app->formatter->asDecimal($sum), [
        'class' => 'badge',
    ]);
    $caption = Html::tag('p', "筛选金额累计 $badge");
}
 */
echo GridView::widget([
    'dataProvider' => $dataProvider,
    // 'caption' => $caption,
    'filterModel' => $searchModel,
    'columns' => [
        // ['class' => 'yii\grid\SerialColumn'],
        'id',
        'username',
        [
            'label' => '角色',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->readableRole;
            },
            'contentOptions' => ['style' => 'width:80px'],
        ],
        [
            'attribute' => 'status',
            'filter' => Lookup::items('user-status'),
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return Lookup::item('user-status', $model->status);
            },
            'contentOptions' => ['style' => 'width:80px'],
        ],
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
            'filter' => Lookup::dateRangeFilter($searchModel, 'created_at'),
            'contentOptions' => ['style' => 'width:150px'],
        ],
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
