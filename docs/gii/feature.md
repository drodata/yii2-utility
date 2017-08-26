# Feature

## Ajax View in Modal

在实际项目中，对那些频繁的查看操作（例如订单的查看）来说，在页面不跳转的情况下，直接通过 AJAX 的方式在 Modal 内显示更加快捷高效。具体实现起来也很简单，问题在于有这种需求的模型可能有多个，为了避免不必要的代码重复，这里我们需要对代码进行抽象。大致思路是：声明一个全局的 click 事件触发函数，用户点击模型的查看链接时，提前拦截以阻止页面跳转，之后根据 query string 中模型 id 发起一个 AJAX GET 请求；将传输过来的 Modal 内容追加到 DOM 中，之后调用 `modal()` 显示内容。

Event handler 定义如下：

```js
// 拦截含有 .modal-view 类名的链接
$(document).on('click', '.modal-view', function(e) {
    e.preventDefault();

    $(this).tooltip('hide');

    var queryString = $(this).prop('href').split('?')[1];
    var slices = $(this).prop('href').split('?')[0].split('/');
    var controller = slices[slices.length - 2];
    var action = slices[slices.length - 1];
    var ajaxRoute = controller + '/modal-' + action + '?' + queryString;

    $.get(APP.baseUrl + ajaxRoute, function(response) {
        $(response).appendTo('body');
        // 所有模型的 modal 的 id 约定为 view-modal
        $('#view-modal').modal('show')
    }).fail(ajax_fail_handler).always(function(){
        $(document).on('hide.bs.modal', '#view-modal', function() {
            $('#view-modal').remove()
        });
    });
});
```

以查看订单操作为例，默认的查看路由是 `order/view?id=1`, 如果我们想让订单的内容在 Modal 内显示，我们只需在链接中添加 `.modal-view` 类即可。之后在控制器中添加如下动作：

```php
public function actionModalView($id)
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    return $this->renderPartial('modal-view', [
        'model' => $this->findModel($id),
    ]);
}
```

`modal-view` 视图文件内容大致如下：

```php
<?php
use yii\bootstrap\Modal;

Modal::begin([
    'id' => 'view-modal',
    'header' => '详情',
    'headerOptions' => [
        'class' => 'h3 text-center',
    ],
]);
?>

    <div class="row">
        <!-- 仅在手机设备上显示 -->
        <div class="col-xs-12 visible-xs-block">
            <?php
            echo $this->render('_detail-action-xs', ['model' => $model]);
            echo $this->render('_detail-view-xs', ['model' => $model]);
            ?>
        </div>
        <!-- 仅在非手机设备上显示 -->
        <div class="col-xs-12 hidden-xs">
            <?php
            echo $this->render('_detail-action', ['model' => $model]);
            echo $this->render('_detail-view', ['model' => $model]);
            ?>
        </div>
    </div>

<?php Modal::end(); ?>
```

在上面的试图还针对手机设备单独显示定制的内容样式。

上面所有的操作都放在了 Gii 模板内。使用该模板生成的代码将原生支持 modal view, 如果不想使用该特性，将标签中的 `.modal-view` 类移除即可。相关 [commit][commit].

[commit]: https://github.com/drodata/yii2-utility/commit/8f77a53d6106e7d4950782c2820bb9eb86d401ef
