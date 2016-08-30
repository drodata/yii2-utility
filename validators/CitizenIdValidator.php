<?php

namespace drodata\validators;
use yii\validators\Validator;

class CitizenIdValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (strlen($model->$attribute) != 18) {
            $this->addError($model, $attribute, '请输入 18 位身份证号码');
        }


        $base = substr(trim($model->$attribute), 0, 17);
        
        if($this->checkSum($base) != strtoupper(substr($model->$attribute, 17, 1))) {
            $this->addError($model, $attribute, '身份证号码不合法');
        }
    }

    protected function checkSum($baseNumber)
    {
        if(strlen($baseNumber) != 17) {
            return false;
        }

        //加权因子
        $factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];

        //校验码对应值
        $map = ['1','0','X','9','8','7','6','5','4','3','2'];
        
        $checksum = 0;
        for($i = 0; $i < strlen($baseNumber); $i++) {
            $checksum += substr($baseNumber, $i, 1) * $factor[$i];
        }
        $mod = $checksum % 11;
        return $map[$mod];
    }
}
