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
     * 从 labelMap 中获取指定属性的配置信息
     */
    protected function lookupConfig($attribute)
    {
        $configs = $this->labelMap[$attribute];

        if (empty($configs)) {
            throw new InvalidConfigException("Please config '$attribute' in the `labelMap` option first");
        }

        return $configs;
    }

    /**
     * 从 lookup 表中查询对应的记录的 name 值。
     *
     * @param string $attribute 属性列名称
     * @return string
     */
    public function lookup($attribute)
    {
        list($type, $colorMap) = $this->lookupConfig($attribute);
        $code = $this->owner->$attribute;

        return Lookup::item($type, $code);
    }

    /**
     * 显示属性对应的标签
     *
     * @param string $attribute 属性列名称
     * @return string
     *
     */
    public function label($attribute)
    {
        list($type, $colorMap) = $this->lookupConfig($attribute);
        $code = $this->owner->$attribute;

        return Html::tag('span', $this->lookup($attribute), [
            'class' => "label label-{$colorMap[$code]}",
        ]);
    }
}
