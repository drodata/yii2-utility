<?php
/**
 * Asset for jqprint (author: eros@recoding.it)
 */
namespace drodata\jqprint;

use drodata\web\AssetBundle;

class PrintAsset extends AssetBundle
{
    public $sourcePath = '@drodata/jqprint';
    public $js = [
        'jqprint.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
