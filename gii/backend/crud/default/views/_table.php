<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

/**
 * 表格视图模板
 */

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

use drodata\helpers\Html;
use backend\models\Lookup;
<?= "?>\n" ?>

<table class="table table-condensed">
    <tbody>
        <tr>
        <?= "<?php " ?>foreach ($model->items as $item): <?= "?>\n"?>
            <td class="text-center"><?= "<?=" ?> $item->id <?= "?>"?></td>
        <?= "<?php " ?>endforeach; <?= "?>\n"?>
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
