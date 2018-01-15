<?php

use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $label string type 对应中文内容 */

$this->title = $label;
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
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
<div class=row "purchase-update">
    <div class="col-md-12 col-lg-4 col-lg-offset-4">
        <?= Box::widget([
            'content' => $this->render('_grid-quick', [
                'dataProvider' => $dataProvider,
            ]),
        ]) ?>
    </div>
</div>
