# Grid

## `drodata\grid\ActionColumn`

GridView 的 Action column 中，默认使用的是 glyphicon, 现在更改为 Font Awesome. 使用方法：

```php
'columns' => [
    ['class' => 'drodata\grid\ActionColumn'],
],
```

## `drodata\grid\UserColumn`

很多模型需要记录操作人的列，例如常见的 `created_by` 和 `updated_by`. 有个模型甚至需要更多的类似列。这些列的值都来自 `user.id` 列。为每一列都添加外键约束意义不大，因为这些列最常见的需求仅仅是显示对应的用户名。

通常境况下，要想在 GridView 或 DetialView 中显示类似列的信息，通常要做如下准备：

首先在模型内设置关系（若提前设置外键约束，Gii 会自动生成）

    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

之后在 GridView::$columns 就可以如下设置：

    [
        'attribute' => 'created_by',
        'value' => function ($model, $key, $index, $column) {
            return $model->creator->display_name;
        },
    ],

在 DetailView::$attributes 设置为：

    'attributes' => [
        [
            'attribute' => 'created_by',
            'value' => $model->creator->display_name,
        ],
    ]

### Usage

每次都要手写上面的代码很麻烦，为了在 GridView 内更方便地显示类似“用户列”，新增一个 `UserColumn`.

首先在 bootstrap 阶段全局配置 UserColumn, 例如：

    // backend/configs/bootstrap.php
    \Yii::$container->set('drodata\grid\UserColumn', [
        'modelClass' => 'backend\models\User',
        'targetAttribute' => 'display_name',
    ]);

之后，在 GridView 中显示类似列就简单了:

    [
        'class' => 'drodata\grid\UserColumn',
        'attribute' => 'created_by',
    ],

### DetailView Enh

事先在 `backend\models\Lookup` 内声明一个 static `userMap()` 方法，返回 id 到名称的映射。由于 `Lookup` 类足够常用（在每个视图内都会 `use`），DetailView 中的设置变成：

    'attributes' => [
        [
            'attribute' => 'created_by',
            'value' => Lookup::userMap($model->created_by),
        ],
    ]


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

![](images/select2-grid-filter.png)
