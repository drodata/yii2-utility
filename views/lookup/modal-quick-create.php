<?php 
use yii\bootstrap\Modal;
use drodata\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Lookup */
/* @var $label string 名称 */

Modal::begin([
    'id' => 'quick-lookup-modal',
    'header' => '新增' . $label,
    'headerOptions' => [
        'class' => 'h3 text-center',
    ],
    'options' => [
    ],
    'size' => Modal::SIZE_SMALL,
]);

echo $this->render('_form-quick', [
    'model' => $model,
    'label' => $label,
]);

Modal::end();
