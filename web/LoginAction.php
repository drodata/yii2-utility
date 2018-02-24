<?php

namespace drodata\web;

use Yii;
use yii\base\Action;
use drodata\models\LoginForm;

class LoginAction extends Action
{

    public $layout;

    public $view = '@drodata/views/site/login';

    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        if ($this->layout !== null) {
            $this->controller->layout = $this->layout;
        }


        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->controller->goBack();
        } else {
            return $this->controller->render($this->view, [
                'model' => $model,
            ]);
        }
    }
}
