<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\bootstrap\Modal;
use drodata\helpers\Html;
use drodata\widgets\Box;
use backend\models\Lookup;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

Modal::begin([
    'id' => 'view-modal',
    'header' => '详情',
    'headerOptions' => [
        'class' => 'h3 text-center',
    ],
    //'size' => Modal::SIZE_LARGE,
]);
<?= "?>\n" ?>

<div class="row">
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
</div>

<?= "<?php Modal::end(); ?>" ?>

