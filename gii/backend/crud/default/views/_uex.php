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

use drodata\helpers\Html;
use backend\models\Lookup;

<?php if ($generator->ajaxSubmit): ?>
$counter = count($model->items);

$ajaxJs = <<<JS
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
$this->registerJs($ajaxJs);
<?php endif; ?>

$commonJs = <<<JS
JS;
$this->registerJs($commonJs);

$create = <<<JS
add_row(idx);
JS;
$update = <<<JS
JS;

if ($model->isNewRecord) {
    $this->registerJs($create);
} else {
    $this->registerJs($update);
}
<?= "?>\n" ?>

