<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$columnNames = $generator->tableSchema->columnNames;
echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

use drodata\helpers\Html;
use backend\models\Lookup;

$slices = [
<?php foreach ($columnNames as $attribute): ?>
    $model-><?= $attribute ?>,
<?php endforeach; ?>
    // Yii::$app->formatter->asInteger($model->quantity),
];

echo implode(' ', $slices);
