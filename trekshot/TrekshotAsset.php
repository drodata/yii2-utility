<?php
/**
 * Some useful small plugins that I created / collected
 *
 * @author drodata@foxmail.com
 */

namespace drodata\trekshot;

use drodata\web\AssetBundle;

class TrekshotAsset extends AssetBundle
{
    public $sourcePath = '@drodata/trekshot';
    public $js = [
        'jquery.trekshot.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
