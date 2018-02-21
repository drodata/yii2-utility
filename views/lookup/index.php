<?php

use yii\widgets\ListView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LookupSearch */
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
];
?>

<div class="row lookup-index">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
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
