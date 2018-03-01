<?php

namespace drodata\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use drodata\helpers\Html;
use drodata\helpers\Utility;
use drodata\behaviors\TimestampBehavior;
use drodata\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%money}}".
 * 
 * @property integer $id
 * @property string $type
 * @property integer $user_id
 * @property string $action
 * @property integer $is_post
 * @property string $amount
 * @property string $note
 * @property integer $created_at
 * @property integer $created_by
 *
 * @property User $user
 */
class Money extends \yii\db\ActiveRecord
{
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%money}}';
    }


    /**
     * @inheritdoc
     * @return MoneyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MoneyQuery(get_called_class());
    }

    /**
     * key means scenario names
     */
    public function transactions()
    {
        return [
            'default' => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'updatedByAttribute' => false,
                'humanReadAttribute' => 'display_name',
            ],
        ];
    }

    /**
     * @inheritdoc
     *
    public function fields()
    {
        $fields = parent::fields();
        
        // 删除涉及敏感信息的字段
        //unset($fields['auth_key']);
        
        // 增加自定义字段
        return ArrayHelper::merge($fields, [
            'time' => function () {
                return $this->readableCreateTime;
            },
            'creator' => function () {
                return $this->readableCreator;
            },
        ]);
    }
    */

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'action', 'is_post', 'amount'], 'required'],
            [['user_id', 'is_post', 'created_at', 'created_by'], 'integer'],
            [['amount'], 'number'],
            [['note'], 'string'],
            [['type'], 'string', 'max' => 50],
            [['action'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类别',
            'user_id' => 'User ID',
            'action' => '动作',
            'is_post' => 'Is Post',
            'amount' => '金额',
            'note' => 'Note',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
