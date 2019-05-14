<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

use drodata\helpers\Html;
use backend\models\Lookup;
?>

<table class="table table-condensed" style="table-layout:fixed">
    <thead>
        <tr>
            <td colspan="4" class="bg-info"></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th width="25%"><?= "<?= " ?>$model->getAttributeLabel('id')<?= " ?>" ?></th>
            <td width="25%"><?= "<?= " ?>$model->id<?= " ?>" ?></td>
            <th width="25%"></th>
            <td width="25%"></td>
        </tr>
        <tr>
            <th></th>
            <td></td>
            <th></th>
            <td></td>
        </tr>
        <tr>
            <th colspan="1"><?= "<?= " ?>$model->getAttributeLabel('note')<?= " ?>" ?></th>
            <td colspan="3"><?= "<?= " ?>$model->note<?= " ?>" ?></td>
        </tr>
    </tbody>
</table>
