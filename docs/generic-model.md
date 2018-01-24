# 通用模型

* [Lookup 快速管理](generic-model-lookup.md)

## 注意事项

- 考虑 table prefix 的情况
  
  使用 Gii 生成这类模型时，注意要勾选使用 Table Prefix, 否则使用了 table prefix 的应用在使用这些模型时，会出现表名不存在的现象。
