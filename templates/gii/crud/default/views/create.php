<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\bootstrap\BaseHtml;
use common\widgets\Panel;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'] = [
	['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']],
	$this->title,
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
