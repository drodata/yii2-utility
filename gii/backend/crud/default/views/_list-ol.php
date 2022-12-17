<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$searchModelClass = StringHelper::basename($generator->searchModelClass);
echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $itemView null|string */

use yii\widgets\ListView;

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => is_null($itemView) ? '_list-item' : $itemView,
    'options' => ['class' => 'row', 'tag' => 'ol'],
    'itemOptions' => ['tag' => 'li'],
    'summary' => '',
    'summaryOptions' => ['class' => 'col-xs-12'],
    'emptyText' => null,
    'emptyTextOptions' => ['class' => 'col-xs-12'],
    'layout' => "{summary}\n{items}\n<div class=\"col-xs-12\">{pager}</div>",
]);
