<?php

use yii\widgets\DetailView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model drodata\models\User */

Box::begin([
    'title' => 'Detail',
    'footer' => $this->render('_list-action', ['model' => $model]),
]);

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        /*
        [
            'label' => '',
            'value' => $model->id,
        ],
        [
            'attribute' => 'amount',
            'format' => 'decimal',
            'contentOptions' => ['class' => 'text-right'],
            'captionOptions' => [
                'class' => 'text-right text-bold',
            ],
        ],
        */
        'id',
        'username',
        'mobile_phone',
        'auth_key',
        'password_hash',
        'password_reset_token',
        'access_token',
        'email:email',
        'status:enum',
        'created_at:datetime',
        'updated_at:datetime',
    ],
]);

Box::end();
