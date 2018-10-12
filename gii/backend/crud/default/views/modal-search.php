<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

use yii\bootstrap\Modal;
use drodata\helpers\Html;

Modal::begin([
    'id' => 'search-modal',
    'header' => '高级搜索',
    'headerOptions' => [
        'class' => 'h3 text-center',
    ],
]);
<?= "?>\n" ?>

<div class="row">
    <div class="col-xs-12">
        <?= "<?= " ?>$this->render('_search', ['model' => $model])<?= " ?>\n" ?>
    </div>
</div>

<?= "<?php Modal::end(); ?>" ?>

