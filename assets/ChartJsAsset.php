<?php
/**
 * Asset for http://www.chartjs.org/ 
 */
namespace drodata\assets;
use yii\web\AssetBundle;

class ChartJsAsset extends AssetBundle
{
    public $sourcePath = '@bower/chartjs/dist';
    public $js = [
        'Chart.bundle.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
