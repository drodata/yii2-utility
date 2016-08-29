<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use drodata\helpers\Html;
use common\models\Lookup;
?>
<div class="">
    <?= "<?= Html::a(\n" ?>
        $model->id
		, ['/file/delete', 'id' => $model->id]
		, [
			'class' => 'btn btn-xs btn-danger',
			'data' => [
                'method' => 'post',
			    'confirm' => '请再次确认',
            ],
		]
    <?= ") ?>\n" ?>
</div>
