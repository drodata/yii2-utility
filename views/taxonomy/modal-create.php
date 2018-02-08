<?php 
use yii\bootstrap\Modal;
use drodata\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Taxonomy */
/* @var $label string 名称 */
/* @var $hideParent bool 是否隐藏 parent_id 元素 */

Modal::begin([
    'id' => 'taxonomy-modal',
    'header' => '新增' . $label,
    'headerOptions' => [
        'class' => 'h3 text-center',
    ],
    'options' => [
    ],
    'size' => Modal::SIZE_SMALL,
]);

echo $this->render('_form', [
    'model' => $model,
    'label' => $label,
    'hideParent' => $hideParent,
]);

Modal::end();
