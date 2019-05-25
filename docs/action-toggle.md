# ToggleAction

可见性（visibility）是通用模型常用的列，借助此列能实现软删除的功能。借助此 action, 只需要如下简单的配置，就能实现此操作。

## 一、控制器内

```php
// in controller
public function actions()
{
    return [
        'toggle-visibility' => [
            'class' => 'drodata\web\ToggleAction',
            'modelClass' => 'backend\models\Recipe',
        ],
    ];
}

public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                // ...
                [
                    'actions' => ['toggle-visibility'],
                    'allow' => true,
                    'roles' => ['warehouseKeeper'],
                ],
            ],
        ],
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'toggle-visibility' => ['POST'],
            ],
        ],
    ];
}
```
