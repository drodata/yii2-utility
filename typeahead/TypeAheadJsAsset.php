<?php
/**
 * Asset for https://github.com/twitter/typeahead.js
 */
namespace drodata\typeahead;
use yii\web\AssetBundle;

class TypeAheadJsAsset extends AssetBundle
{
    public $sourcePath = '@drodata/typeahead';
    public $js = [
        'typeahead.bundle.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
