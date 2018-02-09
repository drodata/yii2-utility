<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
// 模型中文名称
$modelNameCn = empty($generator->modelNameCn)
    ? Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))
    : $generator->modelNameCn;
echo "<?php\n";
?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
use yii\widgets\ListView;
<?php endif; ?>
use drodata\helpers\Html;
use drodata\widgets\Box;
use common\models\Lookup;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? "use yii\widgets\Pjax;\n" : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "<?= $modelNameCn ?>";
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => "<?= $modelNameCn ?>", 'url' => 'index'],
        '管理',
    ],
    'buttons' => [
        Html::actionLink('/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/create', [
            'type' => 'button',
            'title' => '新建<?= $modelNameCn ?>',
            'icon' => 'plus',
            'color' => 'success',
            'visible' => Yii::$app->user->can('@'),
        ]),
        Html::actionLink('/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/modal-search', [
            'type' => 'button',
            'title' => '高级搜索',
            'icon' => 'search',
            'color' => 'primary',
            'class' => 'modal-search',
            'visible' => false,
        ]),
    ],
    'alerts' => [
        [
            'options' => ['class' => 'alert-info'],
            'body' => 'hello',
            'closeButton' => false,
            'visible' => false, //Yii::$app->user->can(''),
        ], 
    ],
];
?>
<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
<?php if ($generator->enablePjax): ?>
    <?= "<?php " ?>Pjax::begin(); <?= "?>\n" ?>
<?php endif; ?>
<?php if ($generator->indexWidgetType === 'grid'): ?>
<?php if ($generator->enableResponsive): ?>
    <!-- hide on phone -->
    <div class="col-xs-12 hidden-xs">
        <?= "<?php " ?>Box::begin([
        ]);<?= "?>\n" ?>
             <?= "<?= " ?>$this->render('@drodata/views/_button') <?= "?>\n" ?>
             <?= "<?= " ?>$this->render('_grid', [
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]) <?= "?>\n" ?>
        <?= "<?php " ?>Box::end();<?= "?>\n" ?>
    </div>
    <!-- visible on phone -->
    <div class="col-xs-12 visible-xs-block">
        <?= "<?= " ?>$this->render('@drodata/views/_button') <?= "?>\n" ?>
        <?= "<?= " ?>$this->render('_search', [
            'model' => $searchModel,
        ]) <?= "?>\n" ?>
        <?= "<?= " ?>ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'row'],
            'itemOptions' => ['class' => 'col-xs-12'],
            'summaryOptions' => ['class' => 'col-xs-12'],
            'emptyTextOptions' => ['class' => 'col-xs-12'],
            'layout' => "{summary}\n{items}\n<div class=\"col-xs-12\">{pager}</div>",
            'pager' => ['maxButtonCount' => 5],
            'itemView' => '_list-view',
        ]) ?>
    </div>
<?php else: ?>
    <div class="col-xs-12">
        <?= "<?= " ?>$this->render('@drodata/views/_alert') <?= "?>\n" ?>
        <?= "<?php " ?>Box::begin([
        ]);<?= "?>\n" ?>
             <?= "<?= " ?>$this->render('@drodata/views/_button') <?= "?>\n" ?>
             <?= "<?= " ?>$this->render('_grid', [
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]) <?= "?>\n" ?>
        <?= "<?php " ?>Box::end();<?= "?>\n" ?>
    </div>
<?php endif; ?>
<?php else: ?>
    <div class="col-xs-12">
        <?= "<?= " ?>$this->render('@drodata/views/_button') <?= "?>\n" ?>
        <?= "<?= " ?>$this->render('_search', [
            'model' => $searchModel,
        ]) <?= "?>\n" ?>
        <?= "<?= " ?>ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'row'],
            'itemOptions' => ['class' => 'col-sm-12 col-md-6 col-lg-4'],
            'summaryOptions' => ['class' => 'col-xs-12'],
            'emptyTextOptions' => ['class' => 'col-xs-12'],
            'layout' => "{summary}\n{items}\n<div class=\"col-xs-12\">{pager}</div>",
            'itemView' => '_list-view',
        ]) ?>
    </div>
<?php endif; ?>
<?= $generator->enablePjax ? "    <?php Pjax::end(); ?>\n" : "" ?>
</div> <!-- .row -->
