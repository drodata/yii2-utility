<?php

namespace drodata\web;

class AssetBundle extends \yii\web\AssetBundle
{
    public $appendMd5Hash = false;

    public function init()
    {
        parent::init();

        // protect frequent changed assets from being cached by browser
        if ($this->appendMd5Hash) {
            foreach (['css', 'js'] as $prop) {
                for ($i = 0; $i < count($this->$prop); $i++) {
                    $relative = !is_null($this->sourcePath) ?: $this->basePath;
                    $hash = substr(md5_file($relative . '/' . $this->{$prop}[$i]), 0, 10);
                    $this->{$prop}[$i] .= '?v=' . $hash;
                }
            }
        }
    }
}
