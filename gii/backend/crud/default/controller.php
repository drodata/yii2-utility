<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
<?php if (!empty($generator->viewPath)): ?>
    public function init()
    {
        parent::init();
        $this->setViewPath('<?= $generator->viewPath ?>');
    }
<?php endif; ?>

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
             'toggle-visibility' => [
                'class' => 'drodata\web\ToggleAction',
                'modelClass' => 'backend\models\Recipe',
                'toggleAttributes' => 'visible',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete', 'toggle-visibility'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'view', 'modal-view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'toggle-visibility' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Lists all <?= $modelClass ?> models.
     * @return mixed
     */
    public function actionIndex()
    {
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }

    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionView(<?= $actionParams ?>)
    {
        return $this->render('view', [
            'model' => $this->findModel(<?= $actionParams ?>),
        ]);
    }

    /**
     * View a record in modal
     *
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     */
    public function actionModalView(<?= $actionParams ?>)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->renderPartial('modal-view', [
            'model' => $this->findModel(<?= $actionParams ?>),
        ]);

    }

    /**
     * 在 Modal 内高级搜索
     */
    public function actionModalSearch()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->renderPartial('modal-search', [
            'model' => new <?= $searchModelClass ?>(),
        ]);

    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->request->isGet) {
            Yii::$app->session->set('redirectUrl', Yii::$app->request->referrer);
        }

        $model = new <?= $modelClass ?>();

<?php if (!$generator->ajaxSubmit): ?>
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '<?= $generator->modelNameCn ?>已创建');
            return $this->redirect(Yii::$app->session->get('redirectUrl'));
        }
<?php endif; ?>

        return $this->render('create', [
            'model' => $model,
        ]);
    }

<?php if ($generator->ajaxSubmit): ?>
    /**
     * AJAX 提交表单
     */
    public function actionAjaxSubmit()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return <?= $modelClass ?>::ajaxSubmit($_POST);
    }
<?php endif; ?>

    /**
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        if (Yii::$app->request->isGet) {
            Yii::$app->session->set('redirectUrl', Yii::$app->request->referrer);
        }
        $model = $this->findModel(<?= $actionParams ?>);

<?php if (!$generator->ajaxSubmit): ?>
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '修改已保存');
            return $this->redirect(Yii::$app->session->get('redirectUrl'));
        }
<?php endif; ?>

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        $this->findModel(<?= $actionParams ?>)->delete();
        Yii::$app->session->setFlash('success', '已删除');

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * ACTION TEMPLATE. Make changes as your need.
     * Operate an existing <?= $modelClass ?> model.
     *
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionDo(<?= $actionParams ?>)
    {
        if (Yii::$app->request->isGet) {
            Yii::$app->session->set('redirectUrl', Yii::$app->request->referrer);
        }

        list($success, $hint) = $this->findModel(<?= $actionParams ?>)->do();

        Yii::$app->session->setFlash($success ? 'success' : 'warning', $hint);

        return $this->redirect(Yii::$app->session->get('redirectUrl'));
    }

    /**
     * ACTION TEMPLATE. Make changes as your need.
     *
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionFillPrice(<?= $actionParams ?>)
    {
        if (Yii::$app->request->isGet) {
            Yii::$app->session->set('redirectUrl', Yii::$app->request->referrer);
        }

        $model = $this->findModel(<?= $actionParams ?>);
        $items = $model->getTabularItems('fill-price');

        if (
            Model::loadMultiple($items, Yii::$app->request->post()) 
            && Model::validateMultiple($items)
            && 0
        ) {
            Yii::$app->session->setFlash('success', '');
            return $this->redirect(Yii::$app->session->get('redirectUrl'));

        } 

        return $this->render('fill-price', [
            'model' => $model,
            'items' => $items,
        ]);
    }
}
