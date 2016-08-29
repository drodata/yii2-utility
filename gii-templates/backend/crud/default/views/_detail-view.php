<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\widgets\DetailView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use commom\models\Lookup;

/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

?>
<?= "<?php " ?>Box::begin([
    'title' => $model->id,
]);<?= "?>\n" ?>
    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'template' => Html::beginTag('tr')
            . Html::tag('th', '{label}', ['width' => '20%', 'class' => 'text-right'])
            . Html::tag('td', '{value}')
            . Html::endTag('td'),
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
        ],
    ]) ?>
<?= "<?php " ?>Box::end();<?= "?>\n" ?>
