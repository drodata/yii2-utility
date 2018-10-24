<?php

namespace drodata\controllers;

use Yii;
use drodata\models\TaxonomySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * TaxonomyController implements the CRUD actions for Taxonomy model.
 */
class TaxonomyController extends Controller
{
    public $modelClass = 'drodata\models\Taxonomy';
    /**
     * 分类中文名称
     */
    public $name;

    /**
     * 简化模式开关
     */
    public $isLite = false;

    public function init()
    {
        parent::init();

        $this->setViewPath('@drodata/views/taxonomy');
    }

    /**
     * Finds the Taxonomy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Taxonomy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Lists all Taxonomy models.
     * @return mixed
     */
    public function actionIndex()
    {
        // 约定：使用控制器 ID 作为 taxonomy.type 列值
        $searchModel = new TaxonomySearch(['type' => $this->id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'label' => $this->name,
        ]);
    }

    /**
     * Displays a single Taxonomy model.
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
     * 在 Modal 内高级搜索
     */
    public function actionModalSearch()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->renderPartial('modal-search', [
            'model' => new TaxonomySearch(),
        ]);

    }

    /**
     * Creates a new Taxonomy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelClass = $this->modelClass;
        $model = new $modelClass(['type' => $this->id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '新记录已创建');
            return $this->redirect('index');
            //return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'label' => $this->name,
        ]);
    }

    /**
     * 通过 modal 快速新建 taxonomy
     */
    public function actionModalCreate()
    {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $hideParent = (bool) Yii::$app->request->get('hide_parent');
        $parentId = Yii::$app->request->get('parent_id');

        $modelClass = $this->modelClass;
        $model = new $modelClass([
            'type' => $this->id,
            'parent_id' => $parentId,
        ]);

        return $this->renderPartial('modal-create', [
            'model' => $model,
            'label' => $this->name,
            'hideParent' => $hideParent,
        ]);
    }
    public function actionModalSubmit()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return Taxonomy::ajaxSubmit($_POST);
    }

    /**
     * Updates an existing Taxonomy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '修改已保存');
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
            'label' => $this->name,
        ]);
    }

    /**
     * Deletes an existing Taxonomy model.
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

}
