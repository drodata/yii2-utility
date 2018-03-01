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
    /**
     * 所属分类中文名称
     */
    public $name;

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
        // 约定：使用控制器 ID 作为 lookup.type 列值
        $searchModel = new LookupSearch(['type' => $this->id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'label' => $this->name,
        ]);
    }
    /**
     * Creates a new Lookup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lookup([
            'type' => $this->id,
            'code' => Lookup::nextCode($this->id),
            'position' => Lookup::nextCode($this->id),
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '新记录已创建');
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
            'label' => $this->name,
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
            'label' => $this->name,
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
     * 通过 modal 快速新建 lookup
     */
    public function actionModalCreate()
    {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new Lookup([
            'type' => $this->id,
            'code' => Lookup::nextCode($this->id),
            'position' => Lookup::nextCode($this->id),
        ]);

        $content = $this->renderPartial('_form', [
            'model' => $model,
        ]);
        return $this->renderPartial('@drodata/views/_modal', [
            'configs' => [
                'id' => 'lookup-modal',
                'header' => '新增' . $this->name,
                'headerOptions' => [
                    'class' => 'h3 text-center',
                ],
                'options' => [
                ],
                'size' => 'modal-sm',
            ],
            'content' => $content, 
        ]);
    }
    public function actionModalSubmit()
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
            $d['option'] = Html::tag('option', $model->name, [
                'value' => $model->code,
                'selected' => true,
            ]);
        }

        return $d;
    }
}
