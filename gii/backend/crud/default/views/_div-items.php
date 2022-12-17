<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$camelId = Inflector::camel2id(StringHelper::basename($generator->modelClass));

echo "<?php\n";
?>
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

use drodata\helpers\Html;
<?= "?>\n"?>

<div class="row <?= $camelId ?>-items">
    <div class="col-sm-12 hidden-xs">
        <?= "<?php\n" ?>
        //echo $this->render('@backend/views/<?= $camelId ?>-item/_grid-parent', ['model' => $model]);
        <?= "?>\n" ?>
    </div>
    <div class="col-xs-12 visible-xs-block">
        <?= "<?php\n" ?>
        /*
        echo $this->render('@backend/views/<?= $camelId ?>-item/_list-ol', [
            'dataProvider' => $model->getDataProvider('items'),
            'itemView' => '_list-item-span',
        ]);
        */
        <?= "?>\n" ?>
    </div>
</div>

