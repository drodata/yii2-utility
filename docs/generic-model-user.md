# 用户 User

## Schema

Field | Type | Null | Key | Desc
------|------|------|-----|-----
id | BIGINT | NO | PRI |
username | VARCHAR(255) | NO | |
mobile_phone | VARCHAR(11) | YES | | Unique, 为实现手机号登录准备
auth_key | VARCHAR(32) | NO | | 
password_hash | VARCHAR(255) | NO | | 
password_reset_token | VARCHAR(255) | YES | | 
access_token | VARCHAR(255) | YES | | Unique, RESTful API token
email | VARCHAR(255) | YES | | Unique, 为实现邮箱登录准备
status | TINYINT(1) | NO | | 默认值是 1
created_at | INT(11) | NO | |
updated_at | INT(11) | NO | |

## Configuration

```php
return [
    // ...
    'controllerMap' => [
        'user' => [
            'class' => 'drodata\controllers\UserController',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'drodata\models\User',
        ],
        // ...
    ],
];
```
