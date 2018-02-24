<?php

/**
 * 不带分页的 grid 模板，常用显示子条目，例如一个订单所有订货明细
 * 与 _grid 的区别有: 
 * - dataProvider 直接通过模型的 getter (如 getItemsDataProvider()) 获取，不使用 SearchModel
 * - 用到 `footer` 显示累加金额
 * - 不使用 filter
 */

/* @var $this yii\web\View */
/* @var $model drodata\models\User */
use yii\grid\GridView;
use drodata\helpers\Html;
use backend\models\Lookup;
use drodata\models\User;

echo GridView::widget([
    'dataProvider' => $model->itemsDataProvider,
    'showFooter' => !empty($model->itemsDataProvider->models),
    'tableOptions' => ['class' => 'table table-condenced table-striped'],
    'summary' => '',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'username',
        'mobile_phone',
        'auth_key',
        'password_hash',
        'password_reset_token',
        'access_token',
        'email',
        'status',
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
            'filter' => Lookup::dateRangeFilter($searchModel, 'created_at'),
            'contentOptions' => ['style' => 'width:150px'],
        ],
        [
            'attribute' => 'updated_at',
            'format' => 'datetime',
            'filter' => Lookup::dateRangeFilter($searchModel, 'updated_at'),
            'contentOptions' => ['style' => 'width:150px'],
        ],
    ],
]); ?>
