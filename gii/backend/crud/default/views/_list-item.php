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

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;
<?= "?>\n" ?>

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
