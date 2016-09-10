<?php
namespace drodata\helpers;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Some useful static functions
 *
 * @author drodata@foxmail.com
 * @since 1.0.17
 */
class Utility
{
    /**
     * Generate a random float number
     */
    public function randFloat($min = 0, $max = 1, $precision = 2) 
    {
        if ($min > $max) {
            return false;
        }
        
        $mul = 10000000;
        $randFloat = mt_rand($min * $mul, $max * $mul) / $mul;

        return round($randFloat, $precision);
    }
}
