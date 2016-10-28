<?php
/**
 * This is the template for generating an action view file.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\controller\Generator */
/* @var $action string the action ID */

echo "<?php\n";
?>
use drodata\helpers\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params = [
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => [
        ['label' => 'Index', 'url' => 'index'],
        $this->title,
    ],
];

<?= "?>" ?>

<div class="col-sm-12">
<?= "<?php\n" ?>
Box::begin([
    'title' => $this->title,
    'tools' => [
        Html::a(Html::icon('plus'), '', ['class' => 'btn btn-sm btn-primary']),
    ],
]);
<?= "?>\n" ?>

<?= "<?php Box::end();?>" ?>
</div>
