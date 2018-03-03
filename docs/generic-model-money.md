# 应付/预付 Money

此表用来存储各种涉及金额变动的记录。例如客户的账户余额/预付款、供应商的应付金额、员工的预支现金等。

Field | Type | Null | Key | Desc
------|------|------|-----|-----
id | BIGINT | NO | PRI |
type | VARCHAR(50) | NO | | 类别。例如订单（'order'）、用户（'user'） 等
user_id | INT(11) | NO | | 关联用户 ID
action | VARCHAR(100) | NO | |
is_post | TINYINT(1) | NO | | 预付 or 应付（供应商角度）, 预收 or 应收（客户角度）
amount | DECIMAL(10,2) | NO | | 
note | TEXT | YES | | 
created_at | INT(11) | YES | | 创建时间戳
created_by | INT(11) | YES | | 创建人，使用 `user.id` 存储

说明：

- user_id 设置为 user 表的外键。要求类似客户、供应商等表格与用户表共用同一个主键。换句话说，user 表仅存储基本信息，其它模型特有的属性单独建表（例如客户的账户余额、供应商的应付账款等）
- type 列没有设计成 lookup code. 此列对用户不可见，不涉及字典查找的情况，直接存储成字符串更简单；

## 使用

如果应用需要使用此模型，需要创建一个继承 `drodata\models\Money` 的子类。里面主要定义一些类别或动作的常量，以及 event handlers. 下面的实例代码演示了使用 Money 模型存储员工的预借现金和未报销现金：

```php
// in backend\models\Money.php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

class Money extends \drodata\models\Money
{
    const TYPE_USER = 'user';
    const ACTION_BORROW = 'borrow';

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'syncUserMoney']);
    } 
    
    public function syncUserMoney($event)
    {
        $columnName = $this->is_post ? 'debt' : 'deposit';

        $user = $this->user;
        $user->{$columnName} += $this->amount;

        if (!$user->save()) {
            throw new \yii\db\Exception($seller->stringifyErrors());
        }
    }
}
```
