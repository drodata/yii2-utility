<?php

/**
 * 表格视图模板
 */

/* @var $this yii\web\View */
/* @var $model drodata\models\User */

use drodata\helpers\Html;
use backend\models\Lookup;
?>

<table class="table table-condensed">
    <tbody>
        <tr>
        <?php foreach ($model->items as $item): ?>
            <td class="text-center"><?= $item->id ?></td>
        <?php endforeach; ?>
        </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>
<!--
<table class="table table-condensed">
    <thead>
        <tr>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center"></td>
        </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>
-->
