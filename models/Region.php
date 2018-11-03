<?php

namespace drodata\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use drodata\helpers\Html;

/**
 * This is the model class for table "{{%region}}".
 * 
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property integer $position
 *
 * @property Contact[] $contacts
 * @property Contact[] $contacts0
 * @property Contact[] $contacts1
 * @property Region $parent
 * @property Region[] $regions
 */
class Region extends \drodata\db\ActiveRecord
{
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
        return '{{%region}}';
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
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'parent_id', 'position'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['id'], 'unique'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'position' => 'Position',
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
        $route = ["/region/$action", 'id' => $this->id];

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
    public function getContacts()
    {
        return $this->hasMany(Contact::className(), ['city_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts0()
    {
        return $this->hasMany(Contact::className(), ['district_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts1()
    {
        return $this->hasMany(Contact::className(), ['province_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Region::className(), ['id' => 'parent_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::className(), ['parent_id' => 'id']);
    }
}
