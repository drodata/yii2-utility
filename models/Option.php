<?php

namespace drodata\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use drodata\helpers\Html;
use drodata\helpers\Utility;

/**
 * This is the model class for table "{{%option}}".
 * 
 * @property integer $id
 * @property string $scope
 * @property integer $user_id
 * @property integer $plugin_id
 * @property string $type
 * @property string $name
 * @property string $directive
 * @property string $format
 * @property string $value
 * @property string $description
 *
 * @property Plugin $plugin
 * @property User $user
 */
class Option extends \yii\db\ActiveRecord
{
    const SCOPE_APP = 'app';
    const SCOPE_USER = 'user';
    const SCOPE_PLUGIN = 'plugin';
    const TYPE_CONF = 'conf';
    const TYPE_PREF = 'pref';
    const FORMAT_BOOLEAN = 'boolean';
    const FORMAT_INTEGER = 'integer';
    const FORMAT_DECIMAL = 'decimal';
    const FORMAT_JSON = 'json';
    const FORMAT_STRING = 'string';

    public function init()
    {
        parent::init();
        //$this->on(self::EVENT_AFTER_INSERT, [$this, 'handlerName']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%option}}';
    }


    /**
     * @inheritdoc
     * @return OptionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OptionQuery(get_called_class());
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
            [['scope', 'type', 'name', 'directive', 'format', 'value'], 'required'],
            [['user_id', 'plugin_id'], 'integer'],
            [['description'], 'string'],
            [['scope'], 'string', 'max' => 10],
            [['type'], 'string', 'max' => 5],
            [['name', 'value'], 'string', 'max' => 255],
            [['directive'], 'string', 'max' => 100],
            [['format'], 'string', 'max' => 20],
            [['name'], 'unique'],
            [['directive'], 'unique'],
            //[['plugin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plugin::className(), 'targetAttribute' => ['plugin_id' => 'id']],
            //[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
        //['passwordOld', 'inlineV'],
        /*
            [
                'billing_period', 'required', 
                'when' => function ($model, $attribute) {
                    return $model->payment_way != self::PAYMENT_WAY_SINGLE;
                },
                'on' => self::SCENARIO_ACCOUNTANT,
                'whenClient' => "function (attribute, value) {
                    return $('#company-payment_way input:checked').val() != '1';
                }",
            ],
        */
    }

    /* inline validator
    public function inlineV($attribute, $params, $validator)
    {
        if ($this->$attribute != 'a') {
            $this->addError($attribute, 'error message');
            return false;
        }
        return true;
    }
    */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scope' => 'Scope',
            'user_id' => 'User ID',
            'plugin_id' => 'Plugin ID',
            'type' => 'Type',
            'name' => 'Name',
            'directive' => '指令符',
            'format' => 'Format',
            'value' => 'Value',
            'description' => 'Description',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlugin()
    {
        return $this->hasOne(Plugin::className(), ['id' => 'plugin_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param boolean $assoc whether convert to associated array for json data
     */
    public function getDecodedValue($assoc = false)
    {
        switch ($this->value_type) {
            case self::FORMAT_BOOLEAN:
                return intval($this->value);
                break;
            case self::FORMAT_INTEGER:
                return intval($this->value);
                break;
            case self::FORMAT_DECIMAL:
                return floatval($this->value);
                break;
            case self::FORMAT_JSON:
                return json_decode($this->value, $assoc);
                break;
            case self::FORMAT_STRING:
                return $this->value;
                break;

        }
    }
}
