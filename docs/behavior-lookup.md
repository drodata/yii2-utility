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
