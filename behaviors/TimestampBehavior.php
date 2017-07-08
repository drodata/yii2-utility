<?php

namespace drodata\behaviors;

use Yii;

class TimestampBehavior extends \yii\behaviors\TimestampBehavior
{
    /**
     * Get human readable value of $this->createdAtAttribute
     *
     * @param string $format date formatter, available values: 'datetime', 'date'
     * @return string converted date string
     */
    public function getReadableCreatedAt($format = 'datetime')
    {
        // $this->owner is the attached AR model
        $value = $this->owner->{$this->createdAtAttribute};
        return $this->humanRead($value, $format);
    }

    /**
     * Get human readable value of $this->updatedAtAttribute
     *
     * @param string $format date formatter, available values: 'datetime', 'date'
     * @return string converted date string
     */
    public function getReadableUpdatedAt($format = 'datetime')
    {
        $value = $this->owner->{$this->updatedAtAttribute};
        return $this->humanRead($value, $format);
    }

    private function humanRead($value, $format)
    {
        $method = $format == 'datetime' ? 'asDatetime' : 'asDate';
        return Yii::$app->formatter->{$method}($value);
    }
}
