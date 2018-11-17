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
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\bootstrap\ActiveForm */

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;
use kartik\select2\Select2;

<?php if ($generator->ajaxSubmit): ?>
$counter = count($model->items);

$commonJs = <<<JS
var af = $('#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form');
var submitBtn = af.find('button[type=submit]');
var container = af.find('tbody');
var idx = $counter;

function add_row(i) {
    var tpl = $('.tabularRow tbody').html();
    tpl = tpl.replace(/drodata/g, i);
    $(tpl).appendTo(container);

    container.trigger('changed.tabular')
}

$('.add-row').click(function(){
    idx++;
    add_row(idx);
})
container.on('changed.tabular', function(){
    $(this).find('tr').each(function (idx) {
        var a = $(this).find('td:first')
        a.html(idx + 1)
    })
})
$(document).on('click', '.delete-row', function(){
    if (container.find('tr').length > 1) {
        $(this).parents('tr').first().remove();
    }
    container.trigger('changed.tabular')
})
af.submit(function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    $.post(APP.baseUrl + '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/ajax-submit', af.serialize(), function(response) {
        if (!response.status) {
            af.displayErrors(response)
            return false;
        }

        $(response.message).insertAfter(submitBtn);

		setInterval(function(){
			window.location.href = response.redirectUrl;
		},1000);
    }).fail(ajax_fail_handler).always(function(){
    });
});
JS;
$this->registerJs($commonJs);

$create = <<<JS
//$('.field-cost-seller_id').hide();
add_row(idx);
JS;
$update = <<<JS
//$('#cost-payment_way input').trigger('change');
JS;

if ($model->isNewRecord) {
    $this->registerJs($create);
} else {
    $this->registerJs($update);
}
<?php endif; ?>
<?= "?>\n" ?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <?= "<?php " ?>$form = ActiveForm::begin([
        'options' => [
            'class' => 'prevent-duplicate-submission',
            // 如果表单需要上传文件，去掉下面一行的注释
            //'enctype' => 'multipart/form-data',
        ],
<?php if ($generator->ajaxSubmit): ?>
        'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form',
        'action' => 'ajax-submit',
<?php endif; ?>
    ]); ?>
        <!--
        'inputTemplate' => '<div class="input-group"><div class="input-group-addon">$</div>{input}</div>'
        -->
<?php foreach ($generator->getColumnNames() as $attribute) {
    // 'created_at' 等列通过 TimestampBehavior 自动填充
    if (in_array($attribute, $safeAttributes) && !in_array($attribute, ['created_at', 'created_by', 'updated_at', 'updated_by'])) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n";
    }
} ?>

    <?= "<?php " ?>if ($model->isNewRecord): <?= "?>\n" ?>
    <?= "<?php " ?>endif; <?= "?>\n" ?>
    <?= "<?php\n" ?>

    // uncomment next line when using ajax submiting
    // echo $form->field($model, 'id')->label(false)->hiddenInput();

    /**
    if ($model->isNewRecord) {
        echo $form->field($common, 'images[]')->fileInput(['multiple' => true]);
    }
    echo $this->render('_field', [
        'form' => $form,
        'model' => $model,
        'common' => $common,
    ]);
     */
    <?= "?>\n" ?>
    <div class="row">
        <div class="col-lg-6 col-md-12">
        </div>
        <div class="col-lg-6 col-md-12">
        </div>
    </div>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('新建') ?> : <?= $generator->generateString('保存') ?>, [
            'class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'),
        ]) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
<?php if ($generator->ajaxSubmit): ?>
<?= "<?=" ?> $this->render('_tabular-input-template') <?= "?>" ?>
<?php endif; ?>
