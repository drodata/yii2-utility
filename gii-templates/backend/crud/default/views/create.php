<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use common\widgets\Box;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['title'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">
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
