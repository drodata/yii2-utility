<?php

namespace drodata\db;

use Yii;
use yii\helpers\ArrayHelper;

class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * Generic write operation.
     *
     * All AR models extended from this class could insert a record by
     * the following way:
     *
     * ```php
     * MyOwnModel::write([
     *     'attr_a' => 'value_a',
     *     'attr_b' => 'value_b',
     *     // ...
     * ]);
     * ```
     * @param array $attrs name-value pairs of the model
     * @return mixed the created instance
     * @since 1.0.16
     *
     */
    public static function write($attrs)
    {   
        $className = static::className();
        $model = new $className();
        $model->attributes = $attrs;
        if (!$model->save()) {
            throw new \yii\db\Exception(
                "Failed to insert into table " . static::tableName()
                . ": " . $model->stringifyErrors() 
            );
        }

        return $model;
    }

    /**
     * Stringify getErrors() to a string, which is used in exception message.
     *
     *
     * @return string readable error string
     * @since 1.0.16
     *
     */
    public function stringifyErrors()
    {
        if (empty($this->errors)) {
            return '';
        }

        $errors = [];
        foreach ($this->errors as $attr => $msgs) {
            $errors[] = implode('', $msgs);
        }

        return implode('', $errors);
    }

    /**
     * 直接返回第一个错误信息。对某些场景来说（小程序），
     * key 并不重要，且不需要一次性显示过多错误提示信息。
     *
     * @return string
     */
    public function getFirstErrorMessage()
    {
        if (!$this->hasErrors()) {
            return '';
        }

        foreach ($this->getFirstErrors() as $key => $error) {
            $message = $error;
        }

        return $message;
    }
}
