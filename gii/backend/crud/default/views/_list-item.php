<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$columnNames = $generator->tableSchema->columnNames;
echo "<?php\n";
?>

use drodata\helpers\Html;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($columnNames as $attribute): ?>
        <tr>
            <th><?= "<?= " ?>$model->getAttributeLabel('<?= $attribute ?>')<?= "?>" ?></th>
            <td class="text-center"><?= "<?= " ?>$model->getAttributeLabel('<?= $attribute ?>')<?= "?>" ?></td>
        </tr>
<?php endforeach; ?>
    </tbody>
    <tfoot>
    </tfoot>
</table>

<?= "<?= " ?>$this->render('_list-action', ['model' => $model]) <?= "?>\n" ?>
