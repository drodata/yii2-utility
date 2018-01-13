<?php

use yii\widgets\DetailView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;

/* @var $this yii\web\View */
/* @var $model backend\models\Lookup */

$this->title = $model->name;
$this->params = [
    'title' => '详情',
    //'subtitle' => '#' . $model->id,
    'breadcrumbs' => [
        ['label' => 'Lookups', 'url' => ['index']],
        $this->title,
    ],
];
?>
<div class="row lookup-view">
    <div class="col-sm-12 col-lg-8 col-lg-offset-2">
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
