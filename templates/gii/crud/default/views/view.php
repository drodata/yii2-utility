<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use common\models\Lookup;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\bootstrap\BaseHtml;
use yii\widgets\DetailView;
use common\widgets\Panel;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'] = [
	['label' => $this->title, 'url' => ['index']],
	$this->title,
];
?>
<?= '<div class="row">' ?>

	<?= '<?php Panel::begin([
		"title" => $this->title,
	]) ?>' ?>

    	<p>
			<?= "<?= " ?>BaseHtml::a(Yii::t('app.crud', 'Return'), Yii::$app->request->referrer, [
				'class' => 'btn btn-default',
			]) ?>
			<?= "<?= " ?>BaseHtml::a(<?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
			<?= "<?= " ?>BaseHtml::a(<?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
				'class' => 'btn btn-danger',
				'data' => [
					'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
					'method' => 'post',
				],
			]) ?>
    	</p>

		<?= "<?= " ?>DetailView::widget([
			'model' => $model,
			'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "\t\t\t\t'" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "\t\t\t\t'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
			],
		]) ?>
	<?= '<?php Panel::end() ?>' ?>

<?= '</div>' ?>
