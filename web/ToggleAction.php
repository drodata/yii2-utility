<?php

namespace drodata\web;

use Yii;

/**
 * Generic toggle action
 *
 * This action is used to toggle the bool value of $this->toggleAttribute
 */
class ToggleAction extends Action
{
    /**
     * data type tinyint
     */
    public $toggleAttribute = 'visible';

    /**
     * @var string 提示信息
     */
    public $successMessage = '设置已保存';

    public function run($id)
    {
        $model = $this->findModel($id);

        $flag = $model->updateAttributes([$this->toggleAttribute => (int) !$model->{$this->toggleAttribute}]);

        Yii::$app->session->setFlash($flag ? 'success' : 'warning', $flag ? $this->successMessage : 'error');

        return $this->controller->redirect(Yii::$app->request->referrer);
    }
}
