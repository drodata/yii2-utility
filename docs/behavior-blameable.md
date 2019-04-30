# BlameableBehavior

日常开发中，模型中跟 'blameable' 相关的还有两个需求：一是需要显示创建人的名称；二是判断当前模型实例是否由当前登录用户所创建，例如在订单管理页面，通常要放查看、修改和删除按钮，业务员只能看到自己的订单，销售经理能看到所有人的订单，也能看到修改、删除按钮，但是处于禁用状态，因为他不是创建人，在控制按钮的禁用上，需要这么一个方法。

为了避免重复在模型类中声明以上两个方法，现对官方的 BlameableBehavior 加以扩展， 新增如下方法：

- `getIsOwnedByCurrentUser()`
- `getCreator()`
- `getUpdater()`

这样，模型实例就能直接使用类似 `$model->isOwnedByCurrentUser`, `$model->creator->getName()` 这样的表达式了。

