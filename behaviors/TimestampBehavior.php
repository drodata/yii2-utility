<?php

namespace drodata\behaviors;

use Yii;

/**
 * 在官方 TimestampBehavior 基础上增加 getReadableCreateTime() 和
 * getReadableUpdateTime() 两个方法，省去在每个模型中重复声明这两个方法。
 *
 */
class TimestampBehavior extends \yii\behaviors\TimestampBehavior
{
    /**
     * Get human readable value of $this->createdAtAttribute
     *
     * @param string $format date formatter, available values: 'datetime', 'date'
     * @return string converted date string
     */
    public function getReadableCreateTime($format = 'datetime')
    {
        $value = $this->owner->{$this->createdAtAttribute};
        return $this->humanRead($value, $format);
    }

    /**
     * Get human readable value of $this->updatedAtAttribute
     *
     * @param string $format date formatter, available values: 'datetime', 'date'
     * @return string converted date string
     */
    public function getReadableUpdateTime($format = 'datetime')
    {
        $value = $this->owner->{$this->updatedAtAttribute};
        return $this->humanRead($value, $format);
    }

    protected function humanRead($value, $format)
    {
        $method = $format == 'datetime' ? 'asDatetime' : 'asDate';
        return Yii::$app->formatter->{$method}($value);
    }
}
