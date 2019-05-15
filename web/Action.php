<?php

namespace drodata\web;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;

/**
 *
 */
class Action extends \yii\base\Action
{
    /**
     * @var string full qualified class name of the model which will be handled by this action.
     * The class must implement the [[ActiveRecordInterface]].
     */
    public $modelClass;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if ($this->modelClass === null) {
            throw new InvalidConfigException(get_class($this) . '::$modelClass must be set.');
        }
    }

    /**
     * Find the model instance
     */
    public function findModel($id)
    {
        /* @var $modelClass ActiveRecordInterface */
        $modelClass = $this->modelClass;
        $keys = $modelClass::primaryKey();
        if (count($keys) > 1) {
            $values = explode(',', $id);
            if (count($keys) === count($values)) {
                $model = $modelClass::findOne(array_combine($keys, $values));
            }
        } elseif ($id !== null) {
            $model = $modelClass::findOne($id);
        }

        if (isset($model)) {
            return $model;
        }

        throw new NotFoundHttpException("Object not found: $id");
    }
}
