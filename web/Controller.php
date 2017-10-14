<?php

namespace drodata\web;

use Yii;

/**
 *
 */
class Controller extends \yii\web\Controller
{
    /**
     * `return $this->redirect(Yii::$app->request->referrer)` 的简写形式
     */
    public function jumpBack()
    {
        return Yii::$app->getResponse()->redirect(Yii::$app->getRequest()->getReferrer());
    }
}
