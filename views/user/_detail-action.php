<?php

/* action buttons in detail view */

/* @var $this yii\web\View */
/* @var $model drodata\models\User */
?>

<div class="row">
    <div class="col-xs-12">
        <div class="operation-group text-right">
            <?php
            echo $model->actionLink('update', 'button');
            echo $model->actionLink('delete', 'button');
            ?>
        </div>
    </div>
</div>
