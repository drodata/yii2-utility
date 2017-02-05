<?php
/**
 * Asset for https://github.com/weui/weui.js
 */
namespace drodata\weui;

use drodata\web\AssetBundle;

class WeUIJsAsset extends AssetBundle
{
    public $sourcePath = '@drodata/weui';
    public $js = [
        'weui.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
