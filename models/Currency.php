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
 * This is the model class for table "{{%currency}}".
 * 
 * @property string $code
 * @property string $name
 * @property string $symbol
 */
class Currency extends \yii\db\ActiveRecord
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
        return '{{%currency}}';
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
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 50],
            [['symbol'], 'string', 'max' => 20],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => '编码',
            'name' => '名称',
            'symbol' => '符号',
        ];
    }

    /**
     * Render a specified action link, which is usually used in 
     * GridView or ListView.
     *
     * @param string $action action name
     * @param string $type link type, 'icon' and 'button' are available,
     * the former is used in action column in grid view, while the latter
     * is use in list view.
     * @return mixed the link html content
     */
    public function actionLink($action, $type = 'icon')
    {
        $route = '/currency/' . $action;
        switch ($action) {
            case 'view':
                return Html::actionLink(
                    [$route, 'code' => $this->code],
                    [
                        'type' => $type,
                        'title' => '详情',
                        'icon' => 'eye',
                        // comment the next line if you don't want to view model in modal.
                        'class' => 'modal-view',
                    ]
                );
                break;
            case 'update':
                return Html::actionLink(
                    [$route, 'code' => $this->code],
                    [
                        'type' => $type,
                        'title' => '修改',
                        'icon' => 'pencil',
                        'visible' => true, //Yii::$app->user->can(''),
                        'disabled' => false,
                        'disabledHint' => '',
                    ]
                );
                break;
            case 'delete':
                return Html::actionLink(
                    [$route, 'code' => $this->code],
                    [
                        'type' => $type,
                        'title' => '删除',
                        'icon' => 'trash',
                        'color' => 'danger',
                        'data' => [
                            'method' => 'post',
                            'confirm' => $this->getConfirmText($action),
                        ],
                        'visible' => true, //Yii::$app->user->can(''),
                        'disabled' => false,
                        'disabledHint' => '',
                    ]
                );
                break;
        }
    }

    /**
     * 返回可用货币列表数组
     *
     * @param boolean $hideCny 是否隐藏人民币
     *
     * @return array 'code' 到 'name' 的关系数组，用于生成单选框等
     */
    public static function items($hideCny = false)
    {
        $items = ArrayHelper::map(
            static::find()->asArray()->all(),
            'code', 'name'
        );

        if ($hideCny) {
            ArrayHelper::remove($items, 'CNY');
        }

        return $items;
    }
    // ==== getters start ====

    /**
     * 获取 POST 操作前的 confirm 文本内容
     *
     * 模型中有很多类似删除这样的操作：没有视图文件，直接通过控制器完成操作，
     * 操作完成后页面跳转至 referrer 而非首页。这类操作前都需要让客户再次确认。
     *
     * @param string $action 对应 actionLink() 中 $action 值
     */
    public function getConfirmText($action = 'delete')
    {
        switch ($action) {
            case 'delete':
                return "请再次确认删除操作。";
                break;
        }
    }


    // ==== getters end ====

    // ==== event-handlers begin ====

    // ==== event-handlers end ====
}
