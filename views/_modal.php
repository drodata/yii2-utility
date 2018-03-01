<?php 
use yii\bootstrap\Modal;
use drodata\helpers\Html;

/* @var $this yii\web\View */
/* @var $configs array Modal widget 配置数组 */
/* @var $content string  */

Modal::begin($configs);

echo $content;

Modal::end();
