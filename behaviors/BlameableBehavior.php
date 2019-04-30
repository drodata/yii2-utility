<?php

namespace drodata\behaviors;

use Yii;

class BlameableBehavior extends \yii\behaviors\BlameableBehavior
{
    /**
     * user 表中的 screen name
     *
     * DEPRECATING
     */
    public $humanReadAttribute = 'username';

    /**
     * @var string User 类名称
     */
    public $userClass = 'backend\models\User';

    /**
     * 判断 AR 实例是否由当前登录用户负责
     *
     * @return boolean
     */
    public function getIsOwnedByCurrentUser()
    {
        return Yii::$app->user->id == $this->owner->{$this->createdByAttribute};
    }

    /**
     * @return User|null
     */
    public function getCreator()
    {
        return $this->owner->hasOne($this->userClass, ['id' => $this->createdByAttribute]);
    }

    /**
     * @return User|null
     */
    public function getUpdater()
    {
        return $this->owner->hasOne($this->userClass, ['id' => $this->updatedByAttribute]);
    }

    /**
     * DEPRECATING. 使用 $this->creator->getName()
     */
    public function getReadableCreator()
    {
        // 假设 AR 模型中已存在 getCreator() 方法
        return $this->owner->creator->{$this->humanReadAttribute};
    }

    /**
     * DEPRECATING. 使用 $this->updater->getName()
     */
    public function getReadableUpdater()
    {
        // 假设 AR 模型中已存在 getUpdater() 方法
        return $this->owner->updater->{$this->humanReadAttribute};
    }
}
