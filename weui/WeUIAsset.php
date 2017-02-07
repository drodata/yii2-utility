<?php

namespace drodata\assets;

use yii\web\AssetBundle;

/**
 * Asset for WeUI 
 */
class WeUIAsset extends AssetBundle
{
    public $sourcePath = '@bower/weui/dist/';
    public $css = [
        'style/weui.min.css',
    ];
    public $js = [];
    public $depends = [];
}
