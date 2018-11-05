<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_list-item',
    'options' => ['class' => 'row'],
    'itemOptions' => ['tag' => 'ul'],
    'summary' => '',
    'summaryOptions' => ['class' => 'col-xs-12'],
    'emptyTextOptions' => ['class' => 'col-xs-12'],
]);
