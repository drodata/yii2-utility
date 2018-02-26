<?php

use yii\widgets\ListView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel drodata\models\RateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "汇率";
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => "汇率", 'url' => 'index'],
        '管理',
    ],
    'buttons' => [
        Html::actionLink('/rate/create', [
            'type' => 'button',
            'title' => '新建汇率',
            'icon' => 'plus',
            'color' => 'success',
            'visible' => true, //Yii::$app->user->can(''),
        ]),
        Html::actionLink('/rate/modal-search', [
            'type' => 'button',
            'title' => '高级搜索',
            'icon' => 'search',
            'color' => 'primary',
            'class' => 'modal-search',
            'visible' => false,
        ]),
    ],
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => 'hello',
            'closeButton' => false,
            'visible' => false, //Yii::$app->user->can(''),
        ], 
    ],
];
?>
<div class="row rate-index">
    <div class="col-xs-12">
        <?= $this->render('@drodata/views/_alert') ?>
        <?php Box::begin([
        ]);?>
             <?= $this->render('@drodata/views/_button') ?>
             <?= $this->render('_grid', [
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]) ?>
        <?php Box::end();?>
    </div>
</div> <!-- .row -->
