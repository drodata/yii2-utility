<?php

/**
 * Compatibility css file
 */

namespace drodata\assets;

use Yii;
use yii\web\AssetBundle;

class AdminLTECustomAsset extends AssetBundle
{
    public $sourcePath = '@drodata/adminlte/dist/';
    public $css = ['css/custom.css'];
    public $depends = [
        'drodata\assets\AdminLTEAsset',
    ];
}
