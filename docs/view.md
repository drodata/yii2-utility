# 公用视图

## Modal
场景一：yii2-utility 中 gii 生成的 CRUD 代码中，自动将查看操作转换成在 Modal 内查看。`modal-view` 和 `view` 两个视图共用 `_detail-view` 内容，区别是 `modal-view` 内用 Modal widget 包裹。这么做会多出一个 modal-view 视图。

场景二：通用字典模型和分类模型都支持 Modal 内 AJAX 创建。和场景一中的查看操作一样，`create` 和 `modal-create` 两个视图共用 `_form` 视图。问题同样是多了一个 `modal-create` 视图。

如果做一个共用的视图文件，代码就能得到精简。`yii\bootstrap\Modal` 不支持像 `yii\bootstrap\Alert` 那样直接使用 `widget()`, 而只能使用 `begin()` + `end()` 的办法。于是有了下面这个共用视图：

```php
Modal::begin($configs);
echo $content;
Modal::end();
```

视图内除 `$this` 外只有两个可用变量: `$configs` 和 `$content`, 前者是 `yii\bootstrap\Modal` 配置数组，后者是字符类型的内容。
 这样直接在控制器内就能这么写：

 ```php
public function actionModalCreate()
{
    // ...
    return $this->renderPartial('@drodata/views/_modal', [
        'configs' => [
            'id' => 'lookup-modal',
            'header' => '新增' . $this->name,
            'headerOptions' => [
                'class' => 'h3 text-center',
            ],
            'options' => [
            ],
            'size' => 'modal-sm',
        ],
        'content' => $this->renderPartial('_form', ['model' => $model])
    ]);
}
```

好处是省去了 `modal-create.php` 视图。
