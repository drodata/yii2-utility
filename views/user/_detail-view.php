<?php

use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $model drodata\models\User */

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'username',
        'mobile_phone',
        'email:email',
        [
            'attribute' => 'status',
            'value' => Lookup::item('user-status', $model->status),
        ],
        'created_at:datetime',
        [
            'label' => '角色',
            'format' => 'raw',
            'value' => $model->readableRole,
        ],
    ],
]);
