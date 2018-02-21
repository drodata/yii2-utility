<?php

use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $model backend\models\Lookup */
/* @var $label string 中文名称 */

$this->title = "修改$label";
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => $label, 'url' => ['index']],
    ],
];
?>
<div class=row "lookup-update">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?= Box::widget([
            'content' => $this->render('_form', [
                'model' => $model,
                'label' => $label,
            ]),
        ]) ?>
    </div>
</div>
