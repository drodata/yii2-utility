# Grid

## `drodata\grid\ActionColumn`

GridView 的 Action column 中，默认使用的是 glyphicon, 现在更改为 Font Awesome. 使用方法：

```php
'columns' => [
    ['class' => 'drodata\grid\ActionColumn'],
],
```

## `drodata\grid\DataColumn`

Yii2 的 grid filter 默认支持两种：文本框和下拉菜单。如果下拉菜单内容过多，我们可能想让下拉菜单“可以搜索”，就像 Select2 插件那样。`drodata\grid\DataColumn` 新增了布尔类型的 `select2` 属性来控制：

```php
echo GridView::widget([
    // ...
    'columns' => [
        [
            'class' => 'drodata\grid\DataColumn',
            'attribute' => 'type',
            'filter' => Lookup::items('AcceptanceType'),
            'select2' => true,
        ],
    ],
]);
```
效果图：

[](images/select2-grid-filter.png)
