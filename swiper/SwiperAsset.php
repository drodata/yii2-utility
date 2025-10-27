<?php
/**
 * Asset for swiper
 */
namespace drodata\swiper;

use drodata\web\AssetBundle;

class SwiperAsset extends AssetBundle
{
    public $sourcePath = '@drodata/swiper';
    public $js = [
        'swiper-bundle.min.js'
    ];
    public $css = [
        'swiper-bundle.min.css'
    ];
    public $depends = [
    ];
}
