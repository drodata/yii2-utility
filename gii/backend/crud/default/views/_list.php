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
<?= "?>\n" ?>

<?= "<?= " ?>\yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_list-item',
    'options' => ['class' => 'row'],
    'itemOptions' => ['class' => 'col-sm-12 col-md-6 col-lg-4'],
    'summary' => '',
    'summaryOptions' => ['class' => 'col-xs-12'],
    'emptyText' => null,
    'emptyTextOptions' => ['class' => 'col-xs-12'],
    'layout' => "{summary}\n{items}\n<div class=\"col-xs-12\">{pager}</div>",
]) ?>
