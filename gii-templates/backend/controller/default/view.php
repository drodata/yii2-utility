<?php
/**
 * This is the template for generating an action view file.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\controller\Generator */
/* @var $action string the action ID */

echo "<?php\n";
?>
use yii\bootstrap\Html;
use drodata\widgets\Box;

/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params = [
    'title' => $this->title,
    'breadcrumbs' => [
        ['label' => 'Index', 'url' => 'index'],
        $this->title,
    ],
];

<?= "?>" ?>

<?= "<?php\n" ?>
Box::begin([
    'title' => $this->title,
]);
<?= "?>\n" ?>

<?= "<?php Box::end();?>" ?>
