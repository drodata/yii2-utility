<?php

namespace drodata\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 *
 * support customize skin
 */
class AdminLTEWithoutGoogleFontAsset extends AssetBundle
{
    public $sourcePath = '@drodata/adminlte/dist/';
    public $css = ['css/AdminLTE.min.without-google-font.css'];
}
