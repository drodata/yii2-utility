<?php

use yii\widgets\ListView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel drodata\models\TaxonomySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $label string type 对应中文内容 */

$this->title = $label;
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        $label,
    ],
    'buttons' => [
        Html::actionLink("/{$this->context->id}/create", [
            'type' => 'button',
            'title' => '新建' . $label,
            'icon' => 'plus',
            'color' => 'success',
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
<div class="row taxonomy-index">
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
