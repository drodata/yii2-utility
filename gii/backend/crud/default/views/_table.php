<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

/**
 * Table
 */

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

use drodata\helpers\Html;
use backend\models\Lookup;
<?= "?>\n" ?>

<table class="table table-bordered table-detail" style="table-layout:fixed">
    <thead>
        <tr>
            <th width="20%"><?= "<?= " ?>$model->getAttributeLabel('id')<?= " ?>" ?></th>
            <td width="30%"><?= "<?= " ?>$model->getId($raw = true)<?= " ?>" ?></td>
            <th width="20%"><?= "<?= " ?>$model->getAttributeLabel('created_at')<?= " ?>" ?></th>
            <td width="30%"><?= "<?= " ?>Yii::$app->formatter->asDatetime($model->created_at)<?= " ?>" ?></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th></th>
            <td></td>
            <th></th>
            <td></td>
        </tr>
    </tbody>

    <thead>
        <tr>
            <td colspan="4"><?= '<?= ' ?>Html::fwicon('list') <?= '?>' ?> 加工明细</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="4"></td>
        </tr>
    </tbody>
</table>
