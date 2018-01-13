<?php

use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $model backend\models\Lookup */
/* @var $name string 名称 */

$this->title = '修改' . $name;
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
                'name' => $name,
            ]),
        ]) ?>
    </div>
</div>
