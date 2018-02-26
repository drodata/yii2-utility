<?php

use yii\bootstrap\Modal;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model drodata\models\Rate */

Modal::begin([
    'id' => 'view-modal',
    'header' => '汇率详情',
    'headerOptions' => [
        'class' => 'h3 text-center',
    ],
    //'size' => Modal::SIZE_LARGE,
]);
?>

<div class="row">
    <div class="col-xs-12">
        <?= $this->render('@drodata/views/_alert') ?>
        <?php
        echo $this->render('_detail-action', ['model' => $model]);
        echo $this->render('_detail-view', ['model' => $model]);
        ?>
    </div>
</div>

<?php Modal::end(); ?>
