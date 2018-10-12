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

use yii\widgets\DetailView;
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;

$this->title = '<?= $modelNameCn ?>详情';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' =>'<?= $modelNameCn ?>' , 'url' => ['index']],
    ],
];
<?= "?>\n" ?>
<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
<?php if ($generator->enableResponsive): ?>
    <div class="col-xs-12 visible-xs-block">
        <?= "<?php\n" ?>
        Box::begin([
            'title' => $this->title,
            'tools' => [],
        ]);
        echo $this->render('_detail-action-xs', ['model' => $model]);
        echo $this->render('_detail-view-xs', ['model' => $model]);
        Box::end();
        <?= "?>\n" ?>
    </div>
    <div class="col-sm-12 col-lg-8 col-lg-offset-2 hidden-xs">
        <?= "<?php\n" ?>
        Box::begin([
            'title' => $this->title,
            'tools' => [],
        ]);
        echo $this->render('_detail-action', ['model' => $model]);
        echo $this->render('_detail-view', ['model' => $model]);
        Box::end();
        <?= "?>\n" ?>
    </div>
<?php else: ?>
    <div class="col-sm-12 col-lg-8">
        <?= "<?php\n" ?>
        Box::begin([
            'title' => $this->title,
            'tools' => [],
        ]);
        echo $this->render('_detail-action', ['model' => $model]);
        echo $this->render('_detail-view', ['model' => $model]);
        Box::end();
        <?= "?>\n" ?>
    </div>
<?php endif; ?>
</div>
