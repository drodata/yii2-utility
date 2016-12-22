<?php
/**
 * Asset for https://github.com/rochal/jQuery-slimScroll
 *
 * 1.3.8
 *
 * The AdminLTE fixed theme requires this plugin
 */
namespace drodata\typeahead;
use yii\web\AssetBundle;

class SlimScrollAsset extends AssetBundle
{
    public $sourcePath = '@drodata/slimscroll';
    public $js = [
        'jquery.slimscroll.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
