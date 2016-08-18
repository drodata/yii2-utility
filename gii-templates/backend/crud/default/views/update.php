<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\bootstrap\Html;
use common\widgets\Box;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Update {modelClass}: ', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?> . $model-><?= $generator->getNameAttribute() ?>;
$this->params = [
    'title' => $this->title,
    'breadcrumbs' => [
        ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']],
        ['label' => $model-><?= $generator->getNameAttribute() ?>, 'url' => ['view', <?= $urlParams ?>]],
        <?= $generator->generateString('Update') ?>,
    ],
];
?>
<div class=row "<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">
    <div class="col-md-12 col-lg-8 col-lg-offset-2">
        <?= "<?php " ?>Box::begin([
            'title' => $this->title,
        ]);<?= "?>\n" ?>
            <?= "<?= " ?>$this->render('_form', [
                'model' => $model,
            ]) ?>
        <?= "<?php " ?>Box::end();<?= "?>\n" ?>
    </div>
</div>
