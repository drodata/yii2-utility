<?php

namespace drodata\behaviors;

use Yii;
use yii\base\InvalidConfigException;
use drodata\models\Lookup;
use drodata\helpers\Html;

/**
 * 通用字典模型常用行为。例子
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'lookup' => [
 *             'class' => LookupBehavior::className(), 
 *             'labelMap' => [
 *                 'visible' => ['boolean', [
 *                     0 => 'danger',
 *                     1 => 'success',
 *                 ]],
 *             ],
 *         ],
 *     ];
 * }
 *```
 */
class LookupBehavior extends \yii\base\Behavior
{

    /**
     * @var array 标签配置数组。格式如下：
     *
     * ```php
     * [
     *     'status' => ['order-status', [
     *         self::STATUS_UNPAID => 'danger',
     *         self::STATUS_PAID => 'success',
     *     ]],
     * ]
     * ```
     */
    public $labelMap = [];

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

    /**
     * 显示属性对应的标签，需要提前配置 $this->labelMap 属性
     *
     * @param string 属性列名称
     * @return string Bootstrap label 标签
     */
    public function label($attribute)
    {
        $configs = $this->labelMap[$attribute];
        $value = $this->owner->$attribute;

        if (empty($configs)) {
            throw new InvalidConfigException("Please config '$attribute' in the `labelMap` option first");
        }

        list($type, $colorMap) = $configs;

        return Html::tag('span', $this->lookup($type, $value), [
            'class' => "label label-{$colorMap[$value]}",
        ]);
    }
}
