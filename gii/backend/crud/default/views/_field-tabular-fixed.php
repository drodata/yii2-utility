<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>
use drodata\helpers\Html;
use backend\models\Lookup;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $items backend\models\TransferItem[] */

?>

<table class="table table-hovered" style="table-layout:fixed">
    <thead>
        <tr>
            <th style="width:80px;min-width:80px;"></th>
        </tr>
    <thead>

    <tbody>
    <?= "<?php" ?> foreach ($items as $index => $item): ?>
        <tr class="itemRow" data-key="">
            <td></td>
        </tr>
    <?= "<?php" ?> endforeach; ?>
    <tbody>
</table>
