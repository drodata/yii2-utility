<?php

namespace drodata\controllers;

use Yii;
use backend\models\CommonForm;
use drodata\models\Rate;
use drodata\models\RateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * RateController implements the CRUD actions for Rate model.
 */
class RateController extends Controller
{
    public function init()
    {
        parent::init();
        $this->setViewPath('@drodata/views/rate');
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
                        //'actions' => ['create', 'view', 'update', 'delete'],
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
     * Finds the Rate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $date
     * @param string $currency
     * @return Rate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($date, $currency)
    {
        if (($model = Rate::findOne(['date' => $date, 'currency' => $currency])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Lists all Rate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rate model.
     * @param string $date
     * @param string $currency
     * @return mixed
     */
    public function actionView($date, $currency)
    {
        return $this->render('view', [
            'model' => $this->findModel($date, $currency),
        ]);
    }

    /**
     * View a record in modal
     *
     * @param string $date
     * @param string $currency
     */
    public function actionModalView($date, $currency)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->renderPartial('modal-view', [
            'model' => $this->findModel($date, $currency),
        ]);

    }

    /**
     * 在 Modal 内高级搜索
     */
    public function actionModalSearch()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->renderPartial('modal-search', [
            'model' => new RateSearch(),
        ]);

    }

    /**
     * Creates a new Rate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param string $date
     * @param string $currency
     * @return mixed
     */
    public function actionCreate($date, $currency)
    {
        $model = new Rate([
            'date' => $date,
            'currency' => $currency,
        ]);

        if (empty($model->getCurrency())) {
            Yii::$app->session->setFlash('warning', '货币不存在。');
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '汇率已保存');
            return $this->goHome();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Rate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $date
     * @param string $currency
     * @return mixed
     */
    public function actionUpdate($date, $currency)
    {
        $model = $this->findModel($date, $currency);

        if (empty($model->getCurrency())) {
            Yii::$app->session->setFlash('warning', '货币不存在。');
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '汇率已保存');
            return $this->goHome();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Rate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $date
     * @param string $currency
     * @return mixed
     */
    public function actionDelete($date, $currency)
    {
        $this->findModel($date, $currency)->delete();
        Yii::$app->session->setFlash('success', '已删除');

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * 为 Rate 模型上传附件 
     * @param string $date
     * @param string $currency
     * @return mixed
     */
    public function actionUpload($date, $currency)
    {
        $model = $this->findModel($date, $currency);
        // 根据需要修改场景值
        $common = new CommonForm(['scenario' => CommonForm::SCENARIO_XXX]);

        if ($common->load(Yii::$app->request->post())) {
            $common->images = UploadedFile::getInstances($common, 'images');
            if ($common->validate()) {
                $model->on(Rate::EVENT_UPLOAD, [$model, 'insertImages'], $common->images);
                $model->trigger(Rate::EVENT_UPLOAD);
                Yii::$app->session->setFlash('success', '图片已上传。');

                return $this->redirect('index');
            }
        }

        return $this->render('upload', [
            'model' => $model,
            'common' => $common,
        ]);
    }
}
