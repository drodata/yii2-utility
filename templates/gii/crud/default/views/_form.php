<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\bootstrap\BaseHtml;
use yii\bootstrap\ActiveForm;
use drodata\utility\models\Lookup;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
	<?= "<?php " ?>$form = ActiveForm::begin(); ?>
<?php foreach ($generator->getColumnNames() as $attribute) {
	if (in_array($attribute, $safeAttributes)) {
		echo "	<?= " . $generator->generateActiveField($attribute) . " ?>\n";
	}
} ?>
	<?= $form->field($model, 'type')->dropDownList(Lookup::items('SourceType')) ?>

	<?= "<?php\n " ?>
	//$form->field($model, 'type')->dropDownList(Lookup::items('SourceType'))
	<?= "\n?>" ?>

	<div class="form-group">
		<?= "<?= " ?>BaseHtml::submitButton($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Update') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>
	<?= "<?php " ?>ActiveForm::end(); ?>
</div>
