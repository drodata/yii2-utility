<?php

namespace drodata\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use drodata\models\Lookup;
use drodata\models\LookupSearch;
use drodata\helpers\Html;

/**
 * LookupController implements the CRUD actions for Lookup model.
 */
class LookupController extends Controller
{
    public function init()
    {
        parent::init();

        $this->setViewPath('@drodata/views/lookup');
    }

    /**
     * Finds the Lookup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lookup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lookup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Lists all Lookup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LookupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Creates a new Lookup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lookup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '新记录已创建');
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * Displays a single Lookup model.
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
     * View a model in modal
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
     * Updates an existing Lookup model.
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
        ]);
    }

    /**
     * Deletes an existing Lookup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', '已删除');

        return $this->redirect(['index']);
    }

    /**
     * 改变记录的可见性
     *
     * @param integer $id
     * @return mixed
     */
    public function actionToggleVisibility($id)
    {
        $this->findModel($id)->toggleVisibility();
        Yii::$app->session->setFlash('success', '操作成功');

        return $this->redirect(['index']);
    }


    /**
     * 快速新建
     */
    public function actionQuickCreate($type)
    {
        $model = new Lookup([
            'type' => $type,
            'code' => Lookup::nextCode($type),
            'position' => Lookup::nextCode($type),
        ]);
        switch ($type) {
            case 'DemoProduct':
                $name = '临时商品';
                $redirectRoute = '/demo/manage-product';
                break;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', $name . '已创建');
            return $this->redirect($redirectRoute);
        }

        return $this->render('quick-create', [
            'model' => $model,
            'name' => $name,
        ]);
    }
    /**
     * 快速修改（仅修改名称）
     */
    public function actionQuickUpdate($id)
    {
        $model = $this->findModel($id);
        switch ($model->type) {
            case 'DemoProduct':
                $name = '临时商品';
                $redirectRoute = '/demo/manage-product';
                break;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', $name . '已修改');
            return $this->redirect($redirectRoute);
        }

        return $this->render('quick-update', [
            'model' => $model,
            'name' => $name,
        ]);
    }
    /**
     * 通过 modal 快速新建 lookup
    public function actionModalCreate()
    {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new Lookup([
            'type' => $type,
            'code' => Lookup::nextCode($type),
            'position' => Lookup::nextCode($type),
        ]);

        return $this->renderPartial('quick-create-modal', [
            'model' => $model,
            'type' => $type,
        ]);
    }
     */
    public function actionModalCreateSubmit()
    {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$d['status'] = true;
        $model = new Lookup();
        $model->load(Yii::$app->request->post());

		$d['status'] = $model->validate() && $d['status'];

		if (!$model->validate()) {
			$d['errors']['lookup'] = $model->getErrors();
        }
        if ($d['status']) {
            $model->save();
            $d['message'] = '<span class="text-success">已创建</span>';
            $d['entity'] = Html::tag('option', $model->name, [
                'value' => $model->id,
                'selected' => true,
            ]);
        }

        return $d;
    }
}
