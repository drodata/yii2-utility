# 媒体 Media

此表用来存储应用中所有附件。

Field | Type | Null | Key | Desc
------|------|------|-----|-----
id | BIGINT | NO | PRI |
format | VARCHAR(10) | NO | | 附件格式，如 'img', 'pdf', 'doc' 等 
path | VARCHAR(50) | NO | | Hash 后的相对路径
name | VARCHAR(100) | YES | | 上传文件的原始文件名
visible | TINYINT(1) | NO | |
created_at | INT(11) | YES | | 创建时间戳
created_by | INT(11) | YES | | 创建人，使用 `user.id` 存储
