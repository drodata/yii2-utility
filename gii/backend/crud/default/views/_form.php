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
/*
echo '<pre>';
print_r($generator->getTableSchema());
echo '</pre>';
*/
echo "<?php\n";
?>

use drodata\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Lookup;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\bootstrap\ActiveForm */

/*
$js = <<<JS
JS;
$this->registerJs($js);
*/
?>

<?= "<?= " ?>$this->render('@drodata/views/_alert')<?= " ?>\n" ?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <?= "<?php " ?>$form = ActiveForm::begin([
        // 如果表单需要上传文件，去掉下面一行的注释
        // 'options' => ['enctype' => 'multipart/form-data'],
        // 如果表单需要通过 AJAX 提交，去掉下面两行的注释
        // 'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form',
        // 'action' => 'ajax-submit',
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
