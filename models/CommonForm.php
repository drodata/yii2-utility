<?php
namespace drodata\models;

use Yii;
use yii\base\Model;

/**
 */
class CommonForm extends Model
{
    public $user_id;
    public $password;
    public $passwordRepeat;
    public $roles;

    const SCENARIO_CREATE_USER = 'create-user';
    const SCENARIO_UPDATE_USER = 'update-user';
    // switch user via switchIdentity()
    const SCENARIO_SWITCH_USER = 'switch-user';
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roles', 'password'], 'required', 'on' => self::SCENARIO_CREATE_USER],
            [['roles'], 'required', 'on' => self::SCENARIO_UPDATE_USER],

            [['user_id'], 'required', 'on' => self::SCENARIO_SWITCH_USER],

            [['password'], 'string', 'min' => 6],
            [['passwordRepeat'], 'compare', 'compareAttribute' => 'password'],
            /*
            [
                'credit',
                'required',
                'on' => self::SCENARIO_CREATE,
                'when' => function($model) {
                    return $model->role == 'outsourcing';
                },
                'whenClient' => "function (attribute, value) {
                    return $('#userform-role').find('input:checked').val() == 'outsourcing';
                }"
            ],
            ['credit', 'number', 'min' => 1, 'on' => self::SCENARIO_CREATE],

            [
                'credit',
                'required',
                'on' => self::SCENARIO_UPDATE,
                'when' => function($model) {
                    return $model->role == 'outsourcing';
                },
                'whenClient' => "function (attribute, value) {
                    return $('#userform-role').find('input:checked').val() == 'outsourcing';
                }"
            ],
            ['credit', 'number', 'min' => 1, 'on' => self::SCENARIO_UPDATE],

            [['resetpswd'], 'required', 'on' => self::SCENARIO_RESET_PSWD],
            [['resetpswd'], 'string', 'min' => 6, 'on' => self::SCENARIO_RESET_PSWD],
            */
        ];
    }

    public function changepswd()
    {
        if ($this->validate()) {
            $user = Yii::$app->user->identity;
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->passwordNew);
            return $user->update();
        } else {
            return false;
        }
    }
    public function resetpswd($user)
    {
        if ($this->validate()) {
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->resetpswd);
            return $user->update();
        } else {
            return false;
        }
    }

    /**
     * 直接切换用户身份
     */
    public function switchUser()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findIdentity($this->user_id);
        Yii::$app->user->switchIdentity($user);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户',
            'password' => '密码',
            'passwordRepeat' => '重复密码',
            'roles' => '角色',
        ];
    }
}
