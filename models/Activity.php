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
 * This is the model class for table "{{%activity}}".
 * 
 * @property integer $id
 * @property string $type
 * @property integer $reference
 * @property string $action
 * @property string $note
 * @property integer $created_at
 * @property integer $created_by
 */
class Activity extends \yii\db\ActiveRecord
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
        return '{{%activity}}';
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
            [['type', 'action'], 'required'],
            [['reference', 'created_at', 'created_by'], 'integer'],
            [['note'], 'string'],
            [['type'], 'string', 'max' => 50],
            [['action'], 'string', 'max' => 100],
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
            'reference' => '参考模型ID',
            'action' => '动作',
            'note' => 'Note',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
