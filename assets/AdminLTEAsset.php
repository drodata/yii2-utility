<?php

namespace drodata\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 *
 * support customize skin
 */
class AdminLTEAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist/';
    public $js = ['js/app.js'];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'drodata\assets\FontAwesomeAsset',
    ];
    private $_css;

    public function getCss()
    {
        return $this->_css;
    }
    public function setCss($arr)
    {
        $this->_css = $arr;

    }

    public function init()
    {
        parent::init();

        $skin = empty(Yii::$app->params['skin']) ? 'blue' : Yii::$app->params['skin'];
        $this->css = [
            'css/AdminLTE.css',
            'css/skins/skin-' . $skin . '.css',
        ];
    }
}
