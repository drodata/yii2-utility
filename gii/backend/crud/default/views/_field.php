<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $common backend\models\CommonForm */

use drodata\helpers\Html;
use drodata\widgets\Box;
use kartik\select2\Select2;
<?= "?>\n" ?>
<div class="row">
    <div class="col-lg-12">
        <?= "<?= " ?><?php echo $generator->generateActiveField($safeAttributes[0]); ?><?= " ?>\n"?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-lg-12">
    </div>
</div>
