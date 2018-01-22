<?php

namespace drodata\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use drodata\helpers\Html;
use kartik\daterange\DateRangePicker;

/**
 * This is the model class for table "lookup".
 *
 * @property integer $id
 * @property string $name
 * @property integer $code
 * @property string $type
 * @property integer $position
 * @property integer $visible
 */
class Lookup extends \yii\db\ActiveRecord
{
    private static $_items = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lookup';
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
            ['visible', 'default', 'value' => 1],
            [['name', 'code', 'type', 'position'], 'required'],
            [['code', 'position', 'visible'], 'filter', 'filter' => 'intval'],
            [['code', 'position', 'visible'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 90],
            [['name'], 'unique', 'targetAttribute' => ['name', 'type'], 'message' => '{value}已存在'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'code' => 'Code',
            'type' => 'Type',
            'position' => 'Position',
            'visible' => 'Visible',
        ];
    }

    public static function items($type, $key='code')
    {
        return ArrayHelper::map(
            self::find()->where([
                'type' => $type,
                'visible' => 1,
            ])->orderBy('position')->asArray()->all(),
            $key,
            'name'
        );
    }

    public static function item($type,$code)
    {
        return self::findOne([
            'type' => $type,
            'code' => $code,
            'visible' => 1,
        ])->name;
    }

    /**
     * Get the next code of a specified type.
     * @return int
     */
	public static function nextCode($type)
	{
		return self::find()->where(['type' => $type, 'visible' => 1])->max('code') + 1;
	}

    /**
     * 获取指定类型、指定名称的记录 code, 若没找到，直接新建
     * @return int
     */
	public static function fetchCode($type, $name)
	{
        $model = static::findOne(['type' => $type, 'name' => $name]);
        if (empty($model)) {
            $code = static::nextCode($type);
            $model = new Lookup([
                'type' => $type,
                'name' => $name,
                'code' => $code,
                'position' => $code,
            ]);
            if (!$model->save()) {
                throw new \yii\db\Exception('Failed to save.');
            }
        }

        return $model->code;
	}

    public function actionLink($action, $type = 'icon')
    {
        $route = '/lookup/' . $action;
        switch ($action) {
            case 'quick-update':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    [
                        'type' => $type,
                        'title' => '修改',
                        'icon' => 'pencil',
                    ]
                );
                break;
            case 'view':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    [
                        'type' => $type,
                        'title' => '详情',
                        'icon' => 'eye',
                        'class' => 'modal-view',
                    ]
                );
                break;
            case 'update':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    [
                        'type' => $type,
                        'title' => '修改',
                        'icon' => 'pencil',
                    ]
                );
                break;
            case 'delete':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    [
                        'type' => $type,
                        'title' => '删除',
                        'icon' => 'trash',
                        'color' => 'danger',
                        'data' => [
                            'method' => 'post',
                            'confirm' => '请再次确认删除操作。',
                        ],
                    ]
                );
                break;
        }
    }

    /**
     * 改变可见性按钮 Callback. 在 grid view 中使用
     */
    public function toggleVisibilityButton($url, $model, $key)
    {
        return Html::actionLink(
            $url,
            [
                'title' => $model->visible ? '隐藏' : '显示',
                'icon' => $model->visible ? 'toggle-on' : 'toggle-off',
                'color' => 'danger',
                'class' => $model->visible ? '' : 'text-muted',
                'data' => [
                    'method' => 'post',
                ],
            ]
        );
    }

    /**
     * 改变可见性
     */
    public function toggleVisibility()
    {
        $this->visible = !$this->visible;

        if (!$this->save()) {
            throw new \yii\db\Exception('Failed to save.');
        }
    }

    /**
     * Generate a date range filter, which is used in gridview.
     * @param searchModel 模型的 search model
     * @param string attribute 对应的属性列
     * @param array configs 插件自定义配置数组，例如，下面的配置能让日历出现在左侧
     *
     * ```php
     * Lookup::dateRangeFilter($searchModel, 'sent_at', [
     *     'opens' => 'left',
     * ]),
     * ```
     *
     * 例子：
     *
     * ```php
     * 'columns' => [
     *     [
     *         'attribute' => 'created_at',
     *         'format' => 'datetime',
     *         'filter' => Lookup::dateRangeFilter($searchModel, 'dateRange'),
     *     ],
     * ]
     * ```
     */
    public static function dateRangeFilter($model, $attribute, $configs = [])
    {
        return DateRangePicker::widget([
            'model' => $model,
            'attribute' => $attribute,
            'convertFormat'=>true,
            'pluginOptions'=> ArrayHelper::merge($configs, [
                'locale'=>[
                    'format'=>'Ymd',
                    'separator' => '-',
                    'cancelLabel' => '重置',
                ],
                'ranges' => [ 
                    '今天' => ["moment()", "moment()"],
                    '昨天' => ["moment().startOf('day').subtract(1,'days')", "moment().endOf('day').subtract(1,'days')"],
                    '最近3天' => ["moment().subtract(2,'days')", "moment()"],
                    '最近7天' => ["moment().subtract(6,'days')", "moment()"],
                    '本月' => ["moment().startOf('month')", "moment().endOf('month')"],
                ],
            ]),
            'pluginEvents'=> [
                "apply.daterangepicker" => 'function(ev, picker) {
                     $(this).val(picker.startDate.format("YYYYMMDD") + "-" + picker.endDate.format("YYYYMMDD")).trigger("change");
                }',
                "cancel.daterangepicker" => 'function(ev, picker) {$(this).val("").trigger("change");}',
            ],
        ]);
    }
}
