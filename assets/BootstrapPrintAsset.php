<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace drodata\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BootstrapPrintAsset extends AssetBundle
{
	public $sourcePath = '@bower/bootstrap/dist/';
	public $baseUrl  = '@web';
    public $css = [
		'css/bootstrap.min.css',
	];
    public $cssOptions = [
		'media' => 'print',
	];
    public $js = [
	];
    public $depends = [
    ];
}
