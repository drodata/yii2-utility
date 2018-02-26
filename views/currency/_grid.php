<?php

use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $searchModel drodata\models\CurrencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/**
 * 借助 'caption' 属性显示筛选数据累计金额
if (empty(Yii::$app->request->get('CurrencySearch'))) {
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
        'code',
        'name',
        'symbol',
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
