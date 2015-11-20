<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\bootstrap\BaseHtml;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use drodata\utility\Panel;
use drodata\utility\models\Lookup;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'] = [
	['label' => $this->title, 'url' => ['index']],
];
?>
<?= '<div class="row">' ?>

	<?= '<?php Panel::begin([
		"title" => $this->title,
	]) ?>' ?>


<?php if(!empty($generator->searchModelClass)): ?>
		<?= "<?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>
		<p>
			<?= "<?= " ?>BaseHtml::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success']) ?>
		</p>

<?php if ($generator->indexWidgetType === 'grid'): ?>
		<?= "<?= " ?>GridView::widget([
			'dataProvider' => $dataProvider,
			<?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        	'columns' => [\n" : "'columns' => [\n"; ?>
				['class' => 'yii\grid\SerialColumn'], 
<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
			echo "\t\t\t\t'" . $name . "',\n";
        } else {
			echo "\t\t\t\t// '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
			echo "\t\t\t\t'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
			echo "\t\t\t\t// '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
				/*
				[
					'attribute' => 'supplier_name',
					'value' => function ($model, $key, $index, $column) {
						return date('Y-m-d H:i', strtotime($model->c_time));
					},
					'filter' => Lookup::items(''),
				],
				*/
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{view} {update} {delete}',
					'buttons' => [
						'ajax-view' => function ($url, $model, $key) {
							return BaseHtml::a(BaseHtml::icon('eye-open'), '#',[
								'title' => Yii::t('app.crud','View'),
								'data-id' => $model->id,
								'class' => 'ajax-view-voucher',
							]);
						},
					],
				],
			],
		]); ?>
<?php else: ?>
	<?= "<?= " ?>ListView::widget([
		'dataProvider' => $dataProvider,
		'itemOptions' => ['class' => 'item'],
		'itemView' => function ($model, $key, $index, $widget) {
			return BaseHtml::a(BaseHtml::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
		},
	]) ?>
<?php endif; ?>

<?= '	<?php Panel::end() ?>' ?>
<?= '</div>' ?>
