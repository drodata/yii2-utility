<?php

/**
 *
 * 视图中常用的操作按钮区域。通过设置 `buttons` 属性完成，
 * 
 * ```xml
 * <?php
 * $this->params = [
 *     'title' => $this->title,
 *     'buttons' => [
 *         Html::actionLink('/order/create', [
 *             'type' => 'button',
 *             'title' => '新建订单',
 *             'icon' => 'plus',
 *             'color' => 'success',
 *         ]),
 *     ],
 * ];
 * ?>
 * 
 * <div class="col-xs-12">
 *     <?= $this->render('@drodata/views/_button') ?>
 *     <?= $this->render('_grid', [
 *         'searchModel' => $searchModel,
 *         'dataProvider' => $dataProvider,
 *     ]) ?>
 * </div>
 * ```
 */ 
/* @var $this yii\web\View */
?>

<?php if(!empty($this->params['buttons'])): ?>
<div class="row">
    <div class="col-xs-12">
        <div class="operation-group">
            <?= implode("\n", $this->params['buttons']) ?>
        </div>
    </div>
</div>
<?php endif; ?>

