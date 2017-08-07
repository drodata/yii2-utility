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
use common\models\Lookup;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params = [
    'title' => '详情',
    //'subtitle' => '#' . $model->id,
    'breadcrumbs' => [
        ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']],
        $this->title,
    ],
];
?>
<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <div class="col-xs-12 visible-xs-block">
        <?= "<?php\n" ?>
        Box::begin([
            'title' => $this->title,
            'tools' => [],
        ]);
        echo $this->render('_detail-action-xs', ['model' => $model]);
        echo $this->render('_detail-view-xs', ['model' => $model]);
        Box::end();
        <?= "?>\n" ?>
    </div>
    <div class="col-sm-12 col-lg-8 col-lg-offset-2 hidden-xs">
        <?= "<?php\n" ?>
        Box::begin([
            'title' => $this->title,
            'tools' => [],
        ]);
        echo $this->render('_detail-action', ['model' => $model]);
        echo $this->render('_detail-view', ['model' => $model]);
        Box::end();
        <?= "?>\n" ?>
    </div>
</div>
