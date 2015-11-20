<?php
/**
 * This is the template for generating an action view file.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\controller\Generator */
/* @var $action string the action ID */

echo "<?php\n";
?>
use yii\helpers\Html;
use yii\bootstrap\BaseHtml;
use yii\grid\GridView;
use drodata\utility\Panel;
use drodata\utility\models\Lookup;

$this->title = '';
$this->params['breadcrumbs'] = [
	['label' => '', 'url' => ['index']],
	$this->title,
];
<?= "?>" ?>

<div class="row">
	<?php
	echo '<?php Panel::begin([
		"title" => $this->title,
		//"width" => 6,
	]) ?>'."\n\t\t";
	echo '<?= $this->render("_form", ["model" => $model]) ?>'."\n\t";
	echo "<?php Panel::end() ?>\n";
	?>
</div>
