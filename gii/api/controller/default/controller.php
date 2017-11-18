<?php
/**
 * This is the template for generating a controller class file.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\controller\Generator */

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\QueryParamAuth;
use backend\models\<?= StringHelper::basename($generator->controllerModel) ?>;

class <?= StringHelper::basename($generator->controllerClass) ?> extends <?= '\\' . trim($generator->baseClass, '\\') . "\n" ?>
{
    public $modelClass = 'backend\models\<?= StringHelper::basename($generator->controllerModel) ?>';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
    
        // disable the "delete" and "create" actions
        //unset($actions['delete'], $actions['create']);
    
        // customize the data provider preparation with the "prepareDataProvider()" method
        //$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
    
        return $actions;
    }

    /**
     * 覆盖默认的 index action dataprovider
    public function prepareDataProvider()
    {
        $query = <?= StringHelper::basename($generator->controllerModel) ?>::find();
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
     */
}
