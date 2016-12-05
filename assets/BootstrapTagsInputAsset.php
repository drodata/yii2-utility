<?php
/**
 * Asset for https://github.com/bootstrap-tagsinput/bootstrap-tagsinput
 */
namespace drodata\assets;
use yii\web\AssetBundle;

class BootstrapTagsInputAsset extends AssetBundle
{
    public $sourcePath = '@npm/bootstrap-tagsinput/dist';
    public $js = [
        'bootstrap-tagsinput.min.js'
    ];
    public $css = [
        'bootstrap-tagsinput.css',
        'bootstrap-tagsinput-typeahead.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
