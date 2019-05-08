<?php

namespace drodata\filters;

use Yii;
use yii\base\ActionFilter;
use yii\base\InvalidConfigException;
use yii\web\ForbiddenHttpException;

/**
 * 负责人检查 Filter. 防止用户通过 url 操作不输入自己的记录。
 * 使用范例：在订单控制器的 behaviors() 内增加如下配置：
 * 
 * ```php
 * 'owner-check' => [
 *     'class' => 'drodata\filters\OwnerCheck',
 *     'modelClass' => 'backend\models\Order',
 *     'ownerAttribute' => 'customer.own_id',
 *     'errorMessage' => '仅能操作自己负责的订单',
 *     'only' => [
 *         'view', 'update', 'delete',
 *     ],
 * ],
 * ```
 *
 */
class OwnerCheck extends ActionFilter
{
    /**
     * @var string AR 模型类名称 (qualified)
     */
    public $modelClass;

    /**
     * @var string 体现负责人的属性名称，也可以是关联模型上的一个属性，例如 'customer.owned_by'
     */
    public $ownerAttribute;

    /**
     * @var string 错误提示信息
     */
    public $errorMessage = '只有负责人才能操作';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (empty($this->modelClass) || empty($this->ownerAttribute)) {
            throw new InvlidConfigException("The modelClass and ownerAttribute property is required.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        $model = $this->findModel($action);

        $ownerValue = $this->findOwnerValue($model);

        if ($ownerValue == Yii::$app->user->id) {
            return true;
        }

        throw new ForbiddenHttpException($this->errorMessage);
    }

    /**
     * 返回模型的负责人 id
     *
     * @param ActiveRecord $model
     * @return integer
     */
    protected function findOwnerValue($model)
    {
        $slices = explode('.', $this->ownerAttribute);

        if (count($slices) == 1) {
            return $model->{$this->ownerAttribute};
        }

        $attribute = array_pop($slices);

        $relationModel = $model;
        foreach ($slices as $slice) {
            $relationModel = $relationModel->$slice;
        }

        return $relationModel->$attribute;
    }

    /**
     * 返回控制器对应的模型
     *
     * @param yii\base\Action $action
     * @return ActiveRecord $model
     */
    protected function findModel($action)
    {
        $modelClass = $this->modelClass;
        $primaryKeys = $modelClass::primaryKey();

        $map = [];
        foreach ($primaryKeys as $key) {
            $value = Yii::$app->request->get($key);

            if (empty($value)) {
            }

            $map[$key] = $value;
        }

        return $modelClass::findOne($map);
    }
}
