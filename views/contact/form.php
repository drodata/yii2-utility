<?php

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $model drodata\models\Contact */
/* @var $label string */
/* @var $subtitle string */

$do = $model->isNewRecord ? '新建' : '修改';

$this->title = $do . $label;
$this->params = [
    'title' => $this->title,
    'subtitle' => $subtitle,
    'breadcrumbs' => [
        ['label' => $label, 'url' => ['index']],
        $do,
    ],
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => '',
            'closeButton' => false,
            'visible' => false, //Yii::$app->user->can(''),
        ], 
    ],
];
?>
<div class="row rate-create">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <div class="contact-form">
        <?php Box::begin(['title' => $this->title]); ?>
            <?php $form = ActiveForm::begin(); ?>
        
            <?= $this->render('_field', ['form' => $form, 'model' => $model]) ?>
        
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '新建' : '保存', [
                    'class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'),
                ]) ?>
            </div>
        
            <?php ActiveForm::end(); ?>
        
        <?php Box::end(); ?>
        </div>
    </div>
</div>
