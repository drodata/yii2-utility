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

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

<?php if ($generator->indexWidgetType === 'grid'): ?>
use yii\widgets\ListView;
use yii\helpers\Markdown;
<?php endif; ?>
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? "use yii\widgets\Pjax;\n" : '' ?>


$this->title = "<?= $modelNameCn ?>";
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => "<?= $modelNameCn ?>", 'url' => 'index'],
        '管理',
    ],
    'buttons' => [
        Lookup::navigationLink('home', [
            'type' => 'button',
            'visible' => false,
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
        <?= "<?= " ?>$this->render('_search', ['model' => $searchModel]) <?= "?>\n" ?>
        <?= "<?= " ?>$this->render('_list', ['dataProvider' => $dataProvider]) <?= "?>\n" ?>
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
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]) <?= "?>\n" ?>
        <?= "<?= " ?>$this->render('_list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]) <?= "?>\n" ?>
    </div>
<?php endif; ?>
<?= $generator->enablePjax ? "    <?php Pjax::end(); ?>\n" : "" ?>
</div> <!-- .row -->
