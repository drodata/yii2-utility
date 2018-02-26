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
 * This is the model class for table "{{%rate}}".
 * 
 * @property string $date
 * @property string $currency
 * @property string $value
 */
class Rate extends \yii\db\ActiveRecord
{
    // const STATUS_ = 1;
    // const SCENARIO_ = '';
    // 单独上传附件事件
    const EVENT_UPLOAD = 'upload';

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
        return '{{%rate}}';
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
            /*
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'updatedByAttribute' => false,
                'humanReadAttribute' => 'display_name',
            ],
            */
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
            [['date', 'currency', 'value'], 'required'],
            [['date'], 'safe'],
            [['value'], 'number', 'min' => 0.0001],
            [['currency'], 'string', 'max' => 3],
            [['date', 'currency'], 'unique', 'targetAttribute' => ['date', 'currency']],
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
            'date' => '日期',
            'currency' => '币种',
            'value' => '汇率',
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
        $route = '/rate/' . $action;
        switch ($action) {
            case 'view':
                return Html::actionLink(
                    [$route, 'date' => $this->date, 'currency' => $this->currency],
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
                    [$route, 'date' => $this->date, 'currency' => $this->currency],
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
                    [$route, 'date' => $this->date, 'currency' => $this->currency],
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
     * 返回货币对象。注意：rate.currency 存储的是 `currency.code` 值
     * @return drodata\models\Currency or null
     */
    public function getCurrency()
    {
        return Currency::findOne(['code' => $this->currency]);
    }

    /**
     * 返回货币名称
     *
     * @return string or null
     */
    public function getCurrencyName()
    {
        return empty($this->getCurrency()) ? null : $this->getCurrency()->name;
    }
    /**
     * 返回货币符号
     *
     * @return string or null
     */
    public function getCurrencySymbol()
    {
        return empty($this->getCurrency()) ? null : $this->getCurrency()->symbol;
    }
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

    /**
     * 从 lookup 表中查询对应的记录的 name 值。
     * 当模型中有多个列使用了 lookup 后，就需要声明多个类似下面的 getter:
     *
     * ```php
     * public function getReadableStatus()
     * {
     *     return Lookup::item('Status', $this->status);
     * }
     * ```
     *
     * 此方法旨在减少上面代码的个数。这在模型详情页非常好用，
     * 且不必添加 backend\models\Lookup 命名空间。
     *
     * @param string type lookup 表中 type 列值
     * @param string code lookup 表中 code 列值
     * @return string|null name 值. 未找到记录时返回 null
     */
    public function lookup($type, $code)
    {
        return Lookup::item($type, $code);
    }

    // ==== getters start ====


    /*
    public function getStatusLabel()
    {
        $map = [
            self::STATUS_ACTIVE => 'success',
            self::STATUS_ARCHIVED => 'default',
        ];
        $class = 'label label-' . $map[$this->status];
        return Html::tag('span', $this->lookup('Status', $this->status), ['class' => $class]);
    }
    */

    /**
     * 无需 sort 和 pagination 的 data provider
     *
    public function getItemsDataProvider()
    {
        return new ActiveDataProvider([
            'query' => static::find(),
            'pagination' => false,
            'sort' => false,
        ]);
    }
    */
    /**
     * 搭配 getItemsDataProvider() 使用，
     * 计算累计值，可用在 grid footer 内
    public function getItemsSum()
    {
        $amount = 0;

        if (empty($this->itemsDataProvider->models)) {
            return $amount;
        }
        foreach ($this->itemsDataProvider->models as $item) {
            $amount += $item->quantity;
        }

        return $amount;
        
    }
     */
    // ==== getters end ====

    /**
     * AJAX 提交表单逻辑代码
     *
    public static function ajaxSubmit($post)
    {
        $d['status'] = true;

        if (empty($post['Spu']['id'])) {
            $model = new Spu();
        } else {
            $model = Spu::findOne($post['Spu']['id']);
        }
        $model->load($post);

        // items
        $items = [];
        foreach ($post['PurchaseItem'] as $index => $item) {
            $items[$index] = new PurchaseItem();
        }
        PurchaseItem::loadMultiple($items, $post);
        foreach ($post['PurchaseItem'] as $index => $item) {
            $d['status'] = $items[$index]->validate() && $d['status'];
            if (!$items[$index]->validate()) {
                $key = "purchaseitem-$index";
                $d['errors'][$key] = $items[$index]->getErrors();
            }
        }

        // all data is safe, start to submit 
        if ($d['status']) {
            // 根据需要调整如 status 列值
            $model->on(self::EVENT_AFTER_INSERT, [$model, 'insertItems'], ['items' => $items]);

            $model->on(self::EVENT_BEFORE_UPDATE, [$model, 'deleteItems']);
            $model->on(self::EVENT_AFTER_UPDATE, [$model, 'insertItems'], ['items' => $items]);

            if (!$model->save()) {
                throw new \yii\db\Exception($model->stringifyErrors());
            }
            
            $d['message'] = Html::tag('span', Html::icon('check') . '已保存', [
                'class' => 'text-success',
            ]);
            $d['redirectUrl'] = Url::to(['/purchase/index']);
        }

        return $d;
    }
    */

    // ==== event-handlers begin ====

    /**
     * 保存附件。
     *
     * 可由 self::EVENT_AFTER_INSERT, self::EVENT_UPLOAD 等触发
     *
     * @param yii\web\UploadedFile $event->data 承兑图片
    public function insertImages($event)
    {
        $images = $event->data;

        Media::store([
            'files' => $images,
            'referenceId' => $this->id,
            'type' => Media::TYPE_IMAGE,
            'category' => Media::CATEGORY_ACCEPTANCE,
            'from2to' => Mapping::ACCEPTANCE2MEDIA,
        ]);
    }
     */

    /**
     * 删除文件
     *
     * 由 self::EVENT_BEFORE_DELETE 触发
    public function deleteImages($event)
    {
        foreach ($this->images as $image) {
            if (!$image->delete()) {
                throw new \yii\db\Exception('Failed to flush image.');
            }
        }
    }
     */
    // ==== event-handlers end ====
}
