# LookupBehavior

通用字典模型最常存储的是类似 MySQL 中的枚举类型的值，例如订单的状态，这类属性的两个常用操作是：显示可读的值（借助 `Lookup::item()`）和显示带颜色的标签（Bootstrap Label）。在模型类中经常需要写类似 `getReadableStatus()`, `getStatusLabel()` 这样的方法，目的是为了能简化在 GridView, DetailView 中的输入。为了避免重复，我们将这些共用的方法统一放在一个行为内。

`LookupBehavior` 主要包含 `lookup()` 和 `label()` 两个方法以及 `labelMap` 属性。使用通用字典模型且具有 LookupBehavior 行为的的其它模型可以直接使用 `lookup()` 实现 `Lookup::item()` 的作用；如需显示彩色的标签，只需在类中配置 `labelMap` 属性，即可使用 `label()`. 下面以 `order.status` 为例，演示一下过程：

首先在 `Order` 模型中注册行为：

```php
public function behaviors()
{
    return [
        'lookup' => [
            'class' => \drodata\behaviors\LookupBehavior::className(), 
            'labelMap' => [
                'status' => ['order-status', [
                    self::STATUS_UNPAID => 'danger',
                    self::STATUS_PAID => 'success',
                ]],
            ],
        ],
    ];
}
```

在 GridView column 配置：

```php
[
    'attribute' => 'status',
    'value' => function ($model, $key, $index, $column) {
        // 普通文本
        return $model->lookup('status');
        // 彩色标签
        return $model->label('status');
    },
    // ...
],
```

### 自定义标签文字内容

`label()` 默认读取字典中的默认值，有的时候，我们可能在显示时简化标签内容。假设有一个“客户类型”列，值分别是“新客户”和“老客户”。为了简单起见，我们希望在 GridView 中仅显示“新”和“老”。可以做如下配置：

```php
// in Customer model
public function behaviors()
{
    return [
        'lookup' => [
            'class' => \drodata\behaviors\LookupBehavior::className(), 
            'labelMap' => [
                'type' => ['customer-type', [
                    self::TYPE_NEW => [
                        'color' => 'success',
                        'text' => '新',
                    ],
                    self::TYPE_OLD => [
                        'color' => 'default',
                        'text' => '旧',
                    ],
                ]],
            ],
        ],
    ];
}
```

## `icon()` 显示带有 Tooltip 的 icon

在 GridView 中，有时一个图标比文字内容更加生动。仿照 `label()` 创建了 `icon()`, 仍以上面的新老客户列为例，这次我们使用字体图标表示：新客户用绿色旗帜表示，老客户用红色旗帜表示。基本配置如下：

```php
// in Customer model
public function behaviors()
{
    return [
        'lookup' => [
            'class' => \drodata\behaviors\LookupBehavior::className(), 
            'iconMap' => [
                'type' => ['customer-type', 'flag', [
                    self::TYPE_NEW => 'success',
                    // 老客户我们使用了更个性化的图标和 tooltip
                    self::TYPE_OLD => [
                        'color' => 'default',
                        'tooltip' => 'This is an old customer!',
                    ],
                ]],
            ],
        ],
    ];
}
```
