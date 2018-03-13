<?php

namespace drodata\controllers;

use Yii;
use drodata\models\CommonForm;
use drodata\models\User;
use drodata\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function init()
    {
        parent::init();
        $this->setViewPath('@drodata/views/user');
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
                        'actions' => ['xxx'], // 禁止访问的放在最前面
                        'allow' => false,
                    ],
                    [
                        //'actions' => ['view', 'modal-view', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * View a record in modal
     *
     * @param integer $id
     */
    public function actionModalView($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->renderPartial('modal-view', [
            'model' => $this->findModel($id),
        ]);

    }

    /**
     * 用户资料
     *
     * @return mixed
     */
    public function actionProfile()
    {
        return $this->render('profile', [
            'model' => $this->findModel(Yii::$app->user->id),
        ]);
    }

    /**
     * 在 Modal 内高级搜索
     */
    public function actionModalSearch()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->renderPartial('modal-search', [
            'model' => new UserSearch(),
        ]);

    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $common = new CommonForm(['scenario' => CommonForm::SCENARIO_CREATE_USER]);

        if (
            $model->load(Yii::$app->request->post()) 
            && $common->load(Yii::$app->request->post()) 
            && $model->validate()
            && $common->validate()
        ) {
            $model->on(User::EVENT_BEFORE_INSERT, [$model, 'generatePassword'], $common->password);
            $model->on(User::EVENT_AFTER_INSERT, [$model, 'saveRoles'], $common->roles);

            $model->save();

            Yii::$app->session->setFlash('success', '用户已创建');
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
            'common' => $common,
        ]);
    }

    /**
     * AJAX 提交表单
     */
    public function actionAjaxSubmit()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return User::ajaxSubmit($_POST);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $common = new CommonForm([
            'scenario' => CommonForm::SCENARIO_UPDATE_USER,
            'roles' => $model->getRoleNames(),
        ]);

        if (
            $model->load(Yii::$app->request->post()) 
            && $common->load(Yii::$app->request->post()) 
            && $model->validate()
            && $common->validate()
        ) {
            $model->on(User::EVENT_AFTER_UPDATE, [$model, 'saveRoles'], $common->roles);

            $model->save();

            Yii::$app->session->setFlash('success', '修改已保存');
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
            'common' => $common,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', '已删除');

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * 为 User 模型上传附件 
     * @param integer $id
     * @return mixed
     */
    public function actionUpload($id)
    {
        $model = $this->findModel($id);
        // 根据需要修改场景值
        $common = new CommonForm(['scenario' => CommonForm::SCENARIO_XXX]);

        if ($common->load(Yii::$app->request->post())) {
            $common->images = UploadedFile::getInstances($common, 'images');
            if ($common->validate()) {
                $model->on(User::EVENT_UPLOAD, [$model, 'insertImages'], $common->images);
                $model->trigger(User::EVENT_UPLOAD);
                Yii::$app->session->setFlash('success', '图片已上传。');

                return $this->redirect('index');
            }
        }

        return $this->render('upload', [
            'model' => $model,
            'common' => $common,
        ]);
    }

    /**
     * 开发环境下为方便调试，快速切换当前用户身份
     */
    public function actionSwitch()
    {
        if (!YII_DEV) {
            throw new ForbiddenHttpException('Only allowed in dev environment.');
        }

        $model = new CommonForm(['scenario' => CommonForm::SCENARIO_SWITCH_USER]);
        if ($model->load(Yii::$app->request->post()) && $model->switchUser()) {
            return $this->goHome();
        }

        return $this->render('switch', [
            'model' => $model,
            'map' => User::map(),
        ]);
    }
}
