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
use drodata\behaviors\TimestampBehavior;
use drodata\behaviors\BlameableBehavior;
use drodata\behaviors\LookupBehavior;

/**
 * This is the model class for table "{{%contact}}".
 * 
 * @property integer $id
 * @property integer $category
 * @property integer $is_lite
 * @property integer $is_main
 * @property integer $visible
 * @property integer $user_id
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $district_id
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $alias
 * @property string $note
 *
 * @property Region $city
 * @property User $user
 * @property Region $district
 * @property Region $province
 */
class Contact extends \drodata\db\ActiveRecord
{
    /**
     * 严格地址模式，精确省市区
     */
    const SCENARIO_STRICT = 'strict';

    public function init()
    {
        parent::init();
        // custom code follows
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact}}';
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
            'lookup' => [
                'class' => LookupBehavior::className(),
                'labelMap' => [
                    'visible' => ['boolean', []],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_lite'], 'default', 'value' => 1],
            [['is_main'], 'default', 'value' => 0],

            [['category', 'name', 'phone', 'address'], 'required'],
            [['category', 'is_lite', 'is_main', 'visible', 'user_id', 'province_id', 'city_id', 'district_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['phone'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 100],
            [['alias'], 'string', 'max' => 10],
            [['note'], 'string', 'max' => 50],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['province_id' => 'id']],

            [['province_id', 'city_id', 'district_id'], 'required', 'on' => self::SCENARIO_STRICT],
        ];
        /**
         * CODE TEMPLATE
         *
            ['passwordOld', 'inlineV'],
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

    /**
     * CODE TEMPLATE inline validator
     *
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
            'id' => '客户ID',
            'category' => 'Category',
            'is_lite' => 'Is Lite',
            'is_main' => 'Is Main',
            'visible' => 'Visible',
            'user_id' => 'User ID',
            'province_id' => '省份',
            'city_id' => '城市',
            'district_id' => '区县',
            'name' => '姓名',
            'phone' => '手机',
            'address' => '地址',
            'alias' => '别称',
            'note' => '备注',
        ];
    }

    /**
     * 反回操作链接
     *
     * @param string $action action name
     * @param array $configs 参考 Html::actionLink()
     * @return mixed the link html content
     */
    public function actionLink($action, $configs = [])
    {
        list($route, $options) = $this->getActionOptions($action);

        return Html::actionLink($route, ArrayHelper::merge($options, $configs));
    }

    /**
     * 返回 actionLink() 核心属性
     *
     * @param string $action 对应 actionLink() 中 $action 值
     * @see actionLink()
     *
     * @return array 两个个元素依次表示：action route, action link options
     *
     */
    public function getActionOptions($action)
    {
        // reset control options
        $visible = true;
        $hint = null;
        $confirm = null;
        $route = ["/contact/$action", 'id' => $this->id];

        switch ($action) {
            case 'view':
                $options = [
                    'title' => '查看',
                    'icon' => 'eye',
                    // disable modal view feature by commenting the following line.
                    'class' => 'modal-view',
                ];
                break;
            case 'update':
                $options = [
                    'title' => '修改',
                    'icon' => 'pencil',
                ];
                break;

            case 'delete':
                $options = [
                    'title' => '删除',
                    'icon' => 'trash',
                    'color' => 'danger',
                    'data' => [
                        'method' => 'post',
                        'confirm' => '确定要执行删除操作吗？',
                    ],
                ];
                break;

            default:
                break;
        }

        // combine control options with common options
        return [$route, ArrayHelper::merge($options, [
            'type' => 'icon',
            'visible' => $visible,
            'disabled' => $hint,
            'disabledHint' => $hint,
        ])];
    }

    // ==== getters start ====

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Region::className(), ['id' => 'city_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(Region::className(), ['id' => 'district_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Region::className(), ['id' => 'province_id']);
    }

    /**
     * 返回联系方式详情
     *
     * @return string
     */
    public function getDetail()
    {
        $slices = [
            $this->name,
            $this->phone,
            $this->address,
        ];

        return implode(', ', $slices);
    }
}
