<?php

namespace drodata\assets;

use yii\web\AssetBundle;

/**
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/fortawesome/font-awesome/';
    public $css = [
        'css/font-awesome.min.css',
    ];
    public $js = [];
    public $depends = [
    ];
}
