<?php

/**
 * AJAX tabular input template
 */
use yii\bootstrap\ActiveForm;
use drodata\helpers\Html;
use backend\models\Lookup;
use backend\models\Goods;

$token = 'drodata';
$goods = new Goods();
$js = <<<JS
$('form#dummy-form').remove();
JS;
$this->registerJs($js);
?>
<?php $form = ActiveForm::begin(['id' => 'dummy-form']); ?>
<?php $form = ActiveForm::end(); ?>

<div class="hide">
    <div class="tabularRow">
        <table><tbody>
            <tr class="itemRow" data-key="<?= $token ?>">
                <td>
                    <?= $form->field($goods, "[$token]warehousing_id")->label(false)->dropDownList(Lookup::warehousingNumbers(), [
                        'prompt' => '',
                    ]) ?>
                </td>
                <td>
                    <?= $form->field($goods, "[$token]qutity", [
                        'inputTemplate' => '<div class="input-group">{input}<div class="input-group-addon">kg</div></div>',
                    ])->label(false)->input('number', [
                        'placeholder' => '',
                    ]) ?>
                </td>
                <td class="text-right">
                    <?= Html::button('删除', ['class' => 'btn btn-sm btn-danger deleteRow']) ?>
                </td>
            </tr>
        </tbody></table>
    </div>
</div>
