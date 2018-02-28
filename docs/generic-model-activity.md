# 活动记录 Activity

此表用来存储模型的各种活动记录

Field | Type | Null | Key | Desc
------|------|------|-----|-----
id | BIGINT | NO | PRI |
type | VARCHAR(50) | NO | | 类别。例如订单（'order'）、用户（'user'） 等
reference | BIGINT | YES | | 参考模型的 ID
action | VARCHAR(100) | NO | |
note | TEXT | YES | | 
created_at | INT(11) | YES | | 创建时间戳
created_by | INT(11) | YES | | 创建人，使用 `user.id` 存储

假设有一个订单模型，当仓库将单号为 1001 的订单进行发货操作时，可以向 activity 表写入如下一条记录：

```
'order', 1001, 'dispatch', null, <timestamp>, 5 
```

用此数据经过拼装，可以生成诸如“某年某月某日 库房将订单 1001 发货，运单号 xxx" 的活动记录。
