<?php

/**
 * Compatibility css file
 */

namespace drodata\assets;

use Yii;
use drodata\web\AssetBundle;

class AdminLTECustomAsset extends AssetBundle
{
    public $sourcePath = '@drodata/adminlte/dist/';
    public $css = ['css/custom.css'];
    public $appendMd5Hash = true;
    public $depends = [
        'drodata\assets\AdminLTEAsset',
    ];
}
