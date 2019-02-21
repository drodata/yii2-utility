<?php
/**
 * 封装后台操作常用的交互增强代码
 * 例如：Bootstrap Modal 打开后自动激活内部的 Popover 特性
 * 全局防止表单重复提交
 *
 * @author drodata@foxmail.com
 */

namespace drodata\assets;

use drodata\web\AssetBundle;

class BackendUexAsset extends AssetBundle
{
    public $sourcePath = '@drodata/assets';
    public $js = [
        'jquery.backend-uex.js'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
