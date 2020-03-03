<?php
/**
 * Asset for https://github.com/yairEO/tagify
 */
namespace drodata\tagify;

use drodata\web\AssetBundle;

class TagifyAsset extends AssetBundle
{
    public $sourcePath = '@drodata/tagify';
    public $js = [
        'jQuery.tagify.min.js'
    ];
    public $css = [
        'tagify.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
