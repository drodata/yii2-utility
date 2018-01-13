<?php

namespace drodata\validators;

use yii\validators\Validator;

/**
 * 验证 '20120101-20181023' 格式
 */
class DateRangeValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $slices = explode('-', $model->$attribute);
        $sample =  date('Ymd') . '-' . date('Ymd', strtotime('tomorrow'));
        if (count($slices) !== 2) {
            $this->addError($model, $attribute, "格式不合法。示例：$sample");
        }
    }
}
