<?php

use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $model drodata\models\Taxonomy */
/* @var $label string type 对应中文内容 */

$this->title = "修改$label";
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => $label , 'url' => ["/{$this->context->id}"]],
    ],
];
?>
<div class=row "taxonomy-update">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?= Box::widget([
            'content' => $this->render('_form', [
                'model' => $model,
                'hideParent' => $this->context->isLite,
            ]),
        ]) ?>
    </div>
</div>
