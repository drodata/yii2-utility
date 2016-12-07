<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']],
        $this->title,
    ],
];
?>
<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">
    <div class="col-md-12 col-lg-6 col-lg-offset-3">
        <?= "<?= " ?>Box::widget([
            'title' => $this->title,
            'content' => $this->render('_form', [
                'model' => $model,
            ]),
        ]) <?= "?>\n" ?>
    </div>
</div>
