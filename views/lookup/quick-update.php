<?php

use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $model backend\models\Lookup */
/* @var $label string 名称 */

$this->title = '修改' . $label;
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
    ],
];
?>
<div class=row "purchase-update">
    <div class="col-md-12 col-lg-4 col-lg-offset-4">
        <?= Box::widget([
            'content' => $this->render('_form-quick', [
                'model' => $model,
                'label' => $label,
            ]),
        ]) ?>
    </div>
</div>
