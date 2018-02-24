<?php

use yii\widgets\DetailView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;

/* @var $this yii\web\View */
/* @var $model drodata\models\User */

$this->title = '用户详情';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'用户' , 'url' => ['index']],
    ],
];
?>
<div class="row user-view">
    <div class="col-sm-12 col-lg-8">
        <?php
        Box::begin([
            'title' => $this->title,
            'tools' => [],
        ]);
        echo $this->render('_detail-action', ['model' => $model]);
        echo $this->render('_detail-view', ['model' => $model]);
        Box::end();
        ?>
    </div>
</div>
