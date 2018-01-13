<?php 
use yii\bootstrap\Modal;
use drodata\helpers\Html;

switch ($type) {
    case 'DemoProduct':
        $name = '临时商品';
        break;
}

Modal::begin([
    'id' => $type . '-modal',
    'header' => '新增' . $name,
    'headerOptions' => [
        'class' => 'h3 text-center',
    ],
    'size' => Modal::SIZE_SMALL,
]);

echo $this->render('_form-quick', [
    'model' => $model,
    'type' => $type,
]);

Modal::end();

