# CRUD

## 在 Grid 内显示筛选数据累加金额

GridView 一个常见的需求是显示筛选数据的累加值。例如一个订单模型，我们通过 filter 筛选出当月所有订单，我们想知道所筛选订单的总金额。这类累加值本来放在 `footer`最合适，但它适合 GridView 没有分页的情况下，当满足要求的记录过多时，这种显示办法会让页面加载很慢。

最好的情况是在支持分页的情况下也能显示，但是如果存在分页，将累加值放在表格最后一行不太好，因为会让人误以为是当前页面数据的累加值。一种思路是放在 `summary` 内，但是无法直接调用 `GridView::renderSumamry()` 方法，因为无法获得 `GridView` 对象。

`caption` 属性用来显示表头信息，其值是一个字符串。`<caption>` 内实际可以放任何 HTML 内容，比如 `Alert` widget, 且它的显示位置刚好在 summary 和表格之间。利用这个特点，我们可以把累加信息放在这里。下面的实例代码演示了如何在承兑模型表格内显示筛选数据的累加金额：

```php
// in _grid.php
if (empty(Yii::$app->request->get('IncomeSearch'))) {
    $caption = '';
} else {
    $sum = 0;
    foreach ($dataProvider->models as $model) {
        $sum += $model->amount;
    }
    $badge = Html::tag('span', Yii::$app->formatter->asDecimal($sum), [
        'class' => 'badge',
    ]);
    $caption = Html::tag('p', "金额累计 $badge");
}

echo GridView::widget([
    // ...
    'caption' => $caption,
]);
```
效果图：

![](images/grid-caption-sum.png)
