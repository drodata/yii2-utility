<?php

namespace drodata\behaviors;

use Yii;
use yii\helpers\ArrayHelper;
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
     * @var array 字体图标配置数组。格式如下：
     *
     * ```php
     * [
     *     'status' => ['order-status', 'icon-name', [
     *         self::STATUS_UNPAID => 'danger',
     *         self::STATUS_PAID => 'success',
     *     ]],
     * ]
     * ```
     * 
     * 更个性化的属性形式:
     * 
     * ```php
     * [
     *     'status' => ['order-status', 'rmb', [
     *         self::STATUS_UNPAID => [
     *             'icon' => 'dollar',
     *             'color' => 'warning',
     *             'tooltip' => 'U',
     *         ],
     *     ]],
     * ]
     * ```
     *
     */
    public $iconMap = [];

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
     * 从 iconMap 中获取指定属性的配置信息
     */
    protected function iconConfig($attribute)
    {
        $configs = $this->iconMap[$attribute];

        if (empty($configs)) {
            throw new InvalidConfigException("Please config '$attribute' in the `iconMap` option first");
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
        $color = $colorMap[$code];

        if (empty($code) || empty($color)) {
            return '';
        }

        if (is_array($color)) {
            $labelColor = ArrayHelper::remove($color, 'color', 'default');
            $labelText = ArrayHelper::remove($color, 'text', $this->lookup($attribute));
        } elseif (is_string($color)) {
            $labelColor = $color;
            $labelText = $this->lookup($attribute);
        }

        return Html::tag('span', $labelText, [
            'class' => "label label-{$labelColor}",
        ]);
    }

    /**
     * 显示属性对应的字体图标
     *
     * @param string $attribute 属性列名称
     * @return string
     *
     */
    public function icon($attribute)
    {
        list($type, $iconName, $colorMap) = $this->iconConfig($attribute);

        $tooltip = $this->lookup($attribute);
        $code = $this->owner->$attribute;
        $color = $colorMap[$code];

        if (empty($code) || empty($color)) {
            return '';
        }

        if (is_array($color)) {
            $iconName = ArrayHelper::remove($color, 'icon', $iconName);
            $iconColor = ArrayHelper::remove($color, 'color', 'default');
            $iconTooltip = ArrayHelper::remove($color, 'tooltip', $this->lookup($attribute));
        } elseif (is_string($color)) {
            $iconColor = $color;
            $iconTooltip = $this->lookup($attribute);
        }

        return Html::tooltipIcon($iconTooltip, $iconName, [
            'class' => "text-{$iconColor}",
        ]);
    }
}
