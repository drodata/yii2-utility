<?php

namespace drodata\behaviors;

class TimestampBehavior extends \yii\behaviors\TimestampBehavior
{
    /**
     * Format a timestamp attribute to date time
     *
     * @param int $attribute
     */
    public function getReadableTimestamp($attribute)
    {
        return Yii::$app->formatter->asDatetime($attribute);
    }
}
