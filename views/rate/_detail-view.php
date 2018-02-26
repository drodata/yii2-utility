<?php

use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $model drodata\models\Rate */

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'date:datetime',
        'currency',
        'value:decimal',
        /*
        [
            'label' => '明细',
            'format' => 'raw',
            'value' => $this->render('_grid-item', ['model' => $model]),
        ],
        */
    ],
]);
