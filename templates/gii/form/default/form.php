<?php
/**
 * This is the template for generating an action view file.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\form\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use drodata\utility\Panel;

/* @var $this yii\web\View */
/* @var $model <?= $generator->modelClass ?> */
/* @var $form ActiveForm */

$this->title = 'xx';
$this->params['breadcrumbs'] = [
	['label' => 'xx', 'url' => ['index']],
	$this->title,
];
<?= "?>" ?>

<?= '<div class="row" id="'.str_replace('/', '-', trim($generator->viewName, '_')).'">' ?>

	<?= '<?php Panel::begin([
		"title" => $this->title,
		"width" => 6,
	]) ?>' ?>

		<?= "<?php " ?>$form = ActiveForm::begin(); ?>
		<?php foreach ($generator->getModelAttributes() as $attribute): ?>
	<?= "<?= " ?>$form->field($model, '<?= $attribute ?>') ?>
		<?php endforeach; ?>
			
		<div class="form-group">
			<?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Submit') ?>, ['class' => 'btn btn-primary']) ?>
		</div>
		<?= "<?php " ?>ActiveForm::end(); ?>
	<?= '<?php Panel::end() ?>' ?>

</div><!-- <?= str_replace('/', '-', trim($generator->viewName, '-')) ?> -->

<?= "<?php\n" ?>
$snippet = <<<SNIPPET
/* Template
var order = $('#order-form').afGetYii2('Order');
$('.field-expressform-customeraddressid').hide();
*/
SNIPPET;
$this->registerJs($snippet);
<?= '?>' ?>
