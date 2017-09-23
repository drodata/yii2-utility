<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">
    <div class="col-xs-12">
        <?= "<?php " ?>Box::begin([
            'title' => '搜索',
            'style' => 'info',
            'tools' => ['collapse'],
        ]);<?= "?>\n" ?>
            <?= "<?php " ?>$form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'options' => ['class' => 'row'],
            ]); ?>
            <div class="col-xs-6">
                <?= "<?php" ?> //echo $form->field($model, 'id')->label(false)->input('number', ['placeholder' => 'ID']); <?= "?>\n" ?>
            </div>
            <div class="col-xs-6">
                <?= "<?php" ?> //echo $form->field($model, 'status')->label(false)->dropDownList(Lookup::items('Status'), ['prompt' => '']); <?= "?>\n" ?>
            </div>
            <div class="col-xs-12">
<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count < 6) {
        echo "            <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    } else {
        echo "            <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    }
}
?>
            <div class="form-group">
                <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('搜索') ?>, ['class' => 'btn btn-primary']) ?>
                <?= "<?= " ?>Html::a('重置', "/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/index", ['class' => 'btn btn-default']) ?>
            </div>
            </div>
            <?= "<?php " ?>ActiveForm::end(); ?>
        <?= "<?php " ?>Box::end();<?= "?>\n" ?>
    </div>
</div>
