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
 * This is the model class for table "{{%directive}}".
 * 
 * @property string $code
 * @property string $name
 * @property string $scope
 * @property string $category
 * @property string $format
 * @property string $description
 * @property integer $position
 * @property integer $visible
 * @property integer $status
 *
 * @property Option[] $options
 */
class Directive extends \drodata\db\ActiveRecord
{
    const SCOPE_APP = 'app';
    const SCOPE_USER = 'user';

    const FORMAT_BOOLEAN = 'boolean';
    const FORMAT_INTEGER = 'integer';
    const FORMAT_DECIMAL = 'decimal';
    const FORMAT_ARRAY = 'array';
    const FORMAT_JSON = 'json';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%directive}}';
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
            [['position'], 'default', 'value' => 0],

            [['code', 'name', 'scope', 'category', 'format'], 'required'],
            [['description'], 'string'],
            [['position', 'visible', 'status'], 'integer'],
            [['code', 'name', 'category'], 'string', 'max' => 45],
            [['scope', 'format'], 'string', 'max' => 10],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => '指令符',
            'name' => '名称',
            'scope' => '作用范围',
            'category' => '类别',
            'format' => '值格式',
            'description' => '说明',
            'position' => '位置排序',
            'visible' => 'Visible',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Option::className(), ['directive_code' => 'code']);
    }

    public function getIsBoolean()
    {
        return $this->format == self::FORMAT_BOOLEAN;
    }
}
