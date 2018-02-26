<?php

use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $model drodata\models\Currency */

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'code',
        'name',
        'symbol',
        /*
        [
            'label' => '明细',
            'format' => 'raw',
            'value' => $this->render('_grid-item', ['model' => $model]),
        ],
        */
    ],
]);
