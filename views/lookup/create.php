<?php

use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $model backend\models\Lookup */

$this->title = '新建';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => 'Lookups', 'url' => ['index']],
        $this->title,
    ],
];
?>
<div class="row lookup-create">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?= Box::widget([
            'title' => $this->title,
            'content' => $this->render('_form', [
                'model' => $model,
            ]),
        ]) ?>
    </div>
</div>
