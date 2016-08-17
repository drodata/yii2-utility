<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\BaseHtml;
use yii\bootstrap\ActiveForm;
use common\widgets\Box;
use commom\models\Lookup;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">
    <div class="col-sm-12">
        <?= "<?php " ?>Box::begin([ 'title' => '搜索', ]);<?= "?>\n" ?>
            <?= "<?php " ?>$form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>
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
                <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary']) ?>
                <?= "<?= " ?>Html::resetButton(<?= $generator->generateString('Reset') ?>, ['class' => 'btn btn-default']) ?>
            </div>
        <?= "<?php " ?>ActiveForm::end(); ?>
    </div>
</div>
