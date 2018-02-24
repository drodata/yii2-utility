<?php

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model drodata\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <?php //echo $form->field($model, 'id')->input('number'); ?>
    </div>
    <div class="col-xs-12 col-sm-6">
        <?php //echo $form->field($model, 'status')->dropDownList(Lookup::items('Status'), ['prompt' => '']); ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= $form->field($model, 'id') ?>

        <?= $form->field($model, 'username') ?>

        <?= $form->field($model, 'mobile_phone') ?>

        <?= $form->field($model, 'auth_key') ?>

        <?= $form->field($model, 'password_hash') ?>

        <?php // echo $form->field($model, 'password_reset_token') ?>

        <?php // echo $form->field($model, 'access_token') ?>

        <?php // echo $form->field($model, 'email') ?>

        <?php // echo $form->field($model, 'status') ?>

        <?php // echo $form->field($model, 'created_at') ?>

        <?php // echo $form->field($model, 'updated_at') ?>

        <div class="form-group">
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('取消', "/user/index", ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
