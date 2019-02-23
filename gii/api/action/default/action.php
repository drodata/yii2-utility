<?php
/**
 * This is the template for generating a controller class file.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\action\Generator */

echo "<?php\n";
?>

namespace <?= $generator->getActionNamespace() ?>;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use <?= trim($generator->modelClass) ?>;

class <?= StringHelper::basename($generator->actionClass) ?> extends yii\rest\CreateAction
{
    public $modelClass = '<?= trim($generator->modelClass) ?>';

    public function run()
    {
    }
}
