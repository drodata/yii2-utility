<?php
/**
 * Some useful small plugins that I created / collected
 *
 * @author drodata@foxmail.com
 */

namespace drodata\assets;

use drodata\web\AssetBundle;

class GenericModelAsset extends AssetBundle
{
    public $sourcePath = '@drodata/assets';
    public $js = [
        'jquery.generic-model.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
