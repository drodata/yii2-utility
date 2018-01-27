# Lookup

此表用来存储字典，建立数据库中的值与显示给用户的值之间的映射。

Field | Type | Null | Key | Desc
------|------|------|-----|-----
id | INT | NO | PRI |
type | VARCHAR(90) | NO | |
name | VARCHAR(50) | NO | | 显示给用户的值
code | TINYINT | NO | | 实际存储的数值
path | VARCHAR(50) | NO | | hashed 相对路径
position | TINYINT | NO | | 供排序使用，默认与 code 值相同
visible | TINYINT | NO | |

配置如下：

```php
// in application configuration
return [
    // ...
    'controllerMap' => [
        'lookup' => [
            'class' => 'drodata\controllers\LookupController',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'], // 只有管理员能访问
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

被赋予 `admin` 角色的用户访问 `lookup/index` 即可管理字典。效果图：

![](images/lookup-manage.png)

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

## Ajax Quick Create

TBD
