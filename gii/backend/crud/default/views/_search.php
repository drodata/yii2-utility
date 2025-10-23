<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $form yii\widgets\ActiveForm */

use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use kartik\select2\Select2;
use backend\models\Lookup;

$commonJs = <<<JS
$('#warehousingsearch-container_id').focus().trigger('select');
JS;
$this->registerJs($commonJs);
$sum = $dataProvider->query->count();
<?= "?>\n" ?>

<?= "<?php " ?>$form = ActiveForm::begin([
    'action' => [$this->context->action->id],
    'method' => 'get',
]); ?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-lg-2">
        <?= "<?php" ?> //echo $form->field($model, 'id')->input('number'); <?= "?>\n" ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-lg-2">
        <?= "<?php" ?> //echo $form->field($model, 'status')->dropDownList(Lookup::items('Status'), ['prompt' => '']); <?= "?>\n" ?>
        <?= "<?php" ?> 
        /*
        echo $form->field($searchModel, 'status')->label(false)->widget(Select2::classname(), [
            'data' => [],
            'options' => ['placeholder' => 'All'],
        ]);

        'inputTemplate' => '<div class="input-group"><div class="input-group-addon">$</div>{input}</div>'
        */
        <?= "?>" ?> 
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
            <div class="col-lg-4 col-md-3 col-sm-6">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('搜索') ?>, ['class' => 'btn btn-primary']) ?>
            <?= "<?= " ?>Html::a('取消', "/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/index", ['class' => 'btn btn-default']) ?>
            <?= "<?= " ?>Html::tag('span', $sum . ' record(s) founded', ['class' => 'text-success']) ?>
        </div>
    </div>
</div>
<?= "<?php " ?>ActiveForm::end(); ?>
