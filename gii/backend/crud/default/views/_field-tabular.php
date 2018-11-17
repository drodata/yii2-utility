<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

use drodata\helpers\Html;
use backend\models\Lookup;
use kartik\select2\Select2;

$js = <<<JS
JS;
$this->registerJs($js);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive" style="margin-bottom: 5px">
            <h4>明细</h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width:120px;">#</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="item-wrapper">
                    <?= "<?php" ?> if (!$model->isNewRecord): <?= "?>\n" ?>
                    <?= "<?=" ?> $this->render('_tabular-input', [
                        'model' => $model,
                        'form' => $form,
                    ]) <?= "?>\n" ?>
                    <?= "<?php" ?> endif; <?= "?>\n" ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right text-bold sum">
                        </td>
                        <td colspan="2" class="text-right">
                            <?= "<?=" ?> Html::button('继续添加', ['class' => 'btn btn-sm btn-info add-row']) <?= "?>\n" ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
