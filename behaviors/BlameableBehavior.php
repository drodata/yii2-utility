<?php

namespace drodata\behaviors;

use Yii;

class BlameableBehavior extends \yii\behaviors\BlameableBehavior
{
    /**
     * user 表中的 screen name
     */
    public $humanReadAttribute = 'username';

    public function getReadableCreator()
    {
        // 假设 AR 模型中已存在 getCreator() 方法
        return $this->owner->creator->{$this->humanReadAttribute};
    }

    public function getReadableUpdater()
    {
        // 假设 AR 模型中已存在 getUpdater() 方法
        return $this->owner->updater->{$this->humanReadAttribute};
    }
}
