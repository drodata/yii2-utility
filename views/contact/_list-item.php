<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Contact */

use drodata\helpers\Html;
?>

<li>
    <?= $model->getDetail() ?>
    <?= $model->actionLink('update') ?>
</li>
