<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\bootstrap\BaseHtml;
use drodata\utility\Panel;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Update {modelClass}: ', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?> . ' ' . $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'] = [
	['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']],
	['label' => $model-><?= $generator->getNameAttribute() ?>, 'url' => ['view', <?= $urlParams ?>]],
	<?= $generator->generateString('Update') ?>,
];
?>

<?= '<div class="row">' ?>

	<?= '<?php Panel::begin([
		"title" => $this->title,
		"width" => 6,
	]) ?>' ?>

		<?= "<?= " ?>$this->render('_form', [
			'model' => $model,
		]) ?> 
	<?= '<?php Panel::end() ?>' ?>

<?= '</div>' ?>
