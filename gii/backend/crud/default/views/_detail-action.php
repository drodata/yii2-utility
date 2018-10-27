<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
<?= "?>\n" ?>

<div class="row">
    <div class="col-xs-12">
        <div class="operation-group text-right">
            <?= "<?php\n" ?>
            echo $model->actionLink('update', ['type' => 'button']);
            echo $model->actionLink('delete', ['type' => 'button']);
            <?= "?>\n" ?>
        </div>
    </div>
</div>
