<?php

/* action buttons in detail view */

/* @var $this yii\web\View */
/* @var $model backend\models\Lookup */
?>

<div class="row">
    <div class="col-xs-12">
        <div class="operation-group text-right">
            <?= $model->actionLink('update', 'button') ?>
            <?= $model->actionLink('delete', 'button') ?>
        </div>
    </div>
</div>
