<?php

namespace drodata\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use drodata\helpers\Html;
use drodata\helpers\Utility;

/**
 * This is the model class for table "{{%option}}".
 * 
 * @property integer $id
 * @property string $directive_code
 * @property string $value
 * @property integer $user_id
 *
 * @property Directive $directiveCode
 * @property User $user
 */
class Option extends \drodata\db\ActiveRecord
{
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
    public function rules()
    {
        return [
            [['directive_code', 'value'], 'required'],
            [['user_id'], 'integer'],
            [['directive_code'], 'string', 'max' => 45],
            [['value'], 'string', 'max' => 255],
            [['directive_code'], 'exist', 'skipOnError' => true, 'targetClass' => Directive::className(), 'targetAttribute' => ['directive_code' => 'code']],
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
            'directive_code' => 'Directive Code',
            'value' => 'Value',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirective()
    {
        return $this->hasOne(Directive::className(), ['code' => 'directive_code']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
