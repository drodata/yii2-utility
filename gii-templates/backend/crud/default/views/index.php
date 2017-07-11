<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

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

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => $this->title, 'url' => 'index'],
        '管理',
    ],
];

// operation buttons
$buttons = [
    Html::actionLink('/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/create', [
        'type' => 'button',
        'title' => '新建',
        'icon' => 'plus',
        'color' => 'success',
    ]),
];
?>
<div class="row <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
<?php if ($generator->enablePjax): ?>
    <?= "<?php " ?>Pjax::begin(); <?= "?>\n" ?>
<?php endif; ?>
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <!-- hide on phone -->
    <div class="col-xs-12 hidden-xs">
        <?= "<?php " ?>Box::begin([
            'title' => $this->title,
            'tools' => [],
        ]);<?= "?>\n" ?>
             <?= "<?= " ?>$this->render('_button', ['buttons' => $buttons]) <?= "?>\n" ?>
             <?= "<?= " ?>$this->render('_grid', [
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]) <?= "?>\n" ?>
        <?= "<?php " ?>Box::end();<?= "?>\n" ?>
    </div>
    <!-- visible on phone -->
    <div class="col-xs-12 visible-xs-block">
        <?= "<?= " ?>$this->render('_button', ['buttons' => $buttons]) <?= "?>\n" ?>
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
        <?= "<?= " ?>$this->render('_button', ['buttons' => $buttons]) <?= "?>\n" ?>
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
<?= $generator->enablePjax ? "    <?php Pjax::end(); ?>\n" : '' ?>
</div> <!-- .row -->
