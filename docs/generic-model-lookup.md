# Lookup

## Lookup Quick Management

Lookup 表内存储的内容主要分两类：一种的值跟代码相关，不允许用户自定义，例如订单的状态；另一类允许用户自定义，例如报销时的分类。前者的值通过在对应模型中定义常量操作，后者的特点是仅使用 `lookup.name` 字段。后者需要一个页面来完成简单的管理操作。这类操作主要包括：新增、修改、隐藏或显示，我们把这类操作集合在 `QuickLookupController` 内。

假设我们的应用是一个报销系统，员工在新建报销时需要选择报销类别，这个类别只有财务有管理权限。这个报销类别就很适合存储在 Lookup 内，假设报销类别的 `lookup.type` 值为 `ExpenseType`, 下面演示一下配置过程：

```php
// in application configuration

return [
    // ...
    'controllerMap' => [
        'expense-type' => [
            'class' => 'drodata\controllers\QuickLookupController',
            'name' => '报销类别',
            'type' => 'ExpenseType',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['accountant'], // 'accountant' 是财务的角色名
                    ],
                ],
            ],
            'as verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ],
    ],
];
```

通过上面的配置，被赋予 `accountant` 的用户访问 `expense-type/index` 即可进行报销类别的管理。效果图如下：

![](images/lookup-quick-manage.png)

