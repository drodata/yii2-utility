<?php

use yii\widgets\ListView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LookupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '字典';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => $this->title, 'url' => 'index'],
        '管理',
    ],
    'buttons' => [
        Html::actionLink('/lookup/create', [
            'type' => 'button',
            'title' => '新建',
            'icon' => 'plus',
            'color' => 'success',
        ]),
    ],
];
?>

<div class="row lookup-index">
    <div class="col-xs-12">
        <?php Box::begin([
            'tools' => [],
        ]);?>
             <?= $this->render('@drodata/views/_button', ['buttons' => $buttons]) ?>
             <?= $this->render('_grid', [
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]) ?>
        <?php Box::end();?>
    </div>
</div> <!-- .row -->
