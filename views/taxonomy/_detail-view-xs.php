<?php
/**
 * detail view on non-mobile device
 */

use yii\widgets\DetailView;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $model drodata\models\Taxonomy */

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'type',
        'name',
        'slug',
        'parent_id',
        [
            'attribute' => 'visible',
            'value' => Lookup::item('TaxonomyVisible', $model->visible),
        ],
        /*
        [
            'label' => '明细',
            'format' => 'raw',
            'value' => $this->render('_grid-item', ['model' => $model]),
        ],
        */
    ],
]);
