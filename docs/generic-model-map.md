# 多对多映射 Map

此表用来存储各种多对多映射。

Field | Type | Null | Key | Desc
------|------|------|-----|-----
id | BIGINT | NO | PRI |
type | VARCHAR(50) | NO | | 'aa-bb' 格式,例如 'sku-2-image'
source | BIGINT | NO | | 模型 id
destination | BIGINT | NO | | 模型 id
