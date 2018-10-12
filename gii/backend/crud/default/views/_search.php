<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use backend\models\Lookup;
<?= "?>\n" ?>

<?= "<?php " ?>$form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <?= "<?php" ?> //echo $form->field($model, 'id')->input('number'); <?= "?>\n" ?>
    </div>
    <div class="col-xs-12 col-sm-6">
        <?= "<?php" ?> //echo $form->field($model, 'status')->dropDownList(Lookup::items('Status'), ['prompt' => '']); <?= "?>\n" ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count < 6) {
        echo "        <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    } else {
        echo "        <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    }
}
?>
        <div class="form-group">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('搜索') ?>, ['class' => 'btn btn-primary']) ?>
            <?= "<?= " ?>Html::a('取消', "/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/index", ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
<?= "<?php " ?>ActiveForm::end(); ?>
