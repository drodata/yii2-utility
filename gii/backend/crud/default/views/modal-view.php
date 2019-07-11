<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
// 模型中文名称
$modelNameCn = empty($generator->modelNameCn)
    ? Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))
    : $generator->modelNameCn;

echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

use yii\bootstrap\Modal;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

Modal::begin([
    'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view-modal',
    'header' => '<?= $modelNameCn ?>详情',
    'headerOptions' => [
        'class' => 'h3 text-center',
    ],
    //'size' => Modal::SIZE_LARGE,
]);
<?= "?>\n" ?>

<div class="row">
<?php if ($generator->enableResponsive): ?>
    <div class="col-xs-12 visible-xs-block">
        <?= "<?php\n" ?>
        echo $this->render('_detail-action-xs', ['model' => $model]);
        echo $this->render('_detail-view-xs', ['model' => $model]);
        <?= "?>\n" ?>
    </div>
    <div class="col-xs-12 hidden-xs">
        <?= "<?php\n" ?>
        echo $this->render('_detail-action', ['model' => $model]);
        echo $this->render('_detail-view', ['model' => $model]);
        <?= "?>\n" ?>
    </div>
<?php else: ?>
    <div class="col-xs-12">
        <?= "<?= " ?>$this->render('@drodata/views/_alert') <?= "?>\n" ?>
        <?= "<?php\n" ?>
        echo $this->render('_detail-action', ['model' => $model]);
        echo $this->render('_detail-view', ['model' => $model]);
        <?= "?>\n" ?>
    </div>
<?php endif; ?>
</div>

<?= "<?php Modal::end(); ?>" ?>

