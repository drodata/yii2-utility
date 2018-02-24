<?php
/**
 * detail view on non-mobile device
 */

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
        'auth_key',
        'password_hash',
        'password_reset_token',
        'access_token',
        'email:email',
        [
            'attribute' => 'status',
            'value' => Lookup::item('user-status', $model->status),
        ],
        'created_at:datetime',
        'updated_at:datetime',
        /*
        [
            'label' => '明细',
            'format' => 'raw',
            'value' => $this->render('_grid-item', ['model' => $model]),
        ],
        */
    ],
]);
