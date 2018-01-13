<?php

use yii\widgets\DetailView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Lookup */

Box::begin([
    'title' => 'Detail',
    'footer' => $this->render('_list-action', ['model' => $model]),
]);

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        /*
        [
            'attribute' => 'product_id',
            'value' => $model->product->size,
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => $model->readableStatus,
        ],
        */
        'id',
        'name',
        'code',
        'type',
        'position',
        'visible',
    ],
]);

Box::end();
