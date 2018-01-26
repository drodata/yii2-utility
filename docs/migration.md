# Migration

在执行 `yii migrate/create` 创建迁移文件时，默认的模板不太好用。我自定义了一个适合自己的模板文件。需要在 console configuration 内配置 `controllerMap` 属性重定向 `templateFile` 属性：

```php
// in console configuration file
return [
    ...
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'templateFile' => '@drodata/views/migration.php',
        ],
    ],
];
```
