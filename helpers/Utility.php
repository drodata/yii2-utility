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
    public static function randFloat($min = 0, $max = 1, $precision = 2) 
    {
        if ($min > $max) {
            return false;
        }
        
        $mul = 10000000;
        $randFloat = mt_rand($min * $mul, $max * $mul) / $mul;

        return round($randFloat, $precision);
    }

    /**
     * 判断两个浮点数是否相等
     *
     * ```php
     * $a = 1.345678;
     * $b = 1.345679;
     * echo Utility::isFloatEqual($a, $b); // true
     * ```
     *
     * @param float|string $a 要比较的第一个操作数. 注意：如果要比较的数字是动态获取的值，一定要考虑值为 0 的可能性，
     * 所以第一个参数最好放置静态值，即不可能是 0 的值，防止除数为 0 的情况出现
     * @param float|string $b 要比较的第一个操作数
     * @param float $epsilon 精度
     * @return bool
     *
     */
    public static function isFloatEqual($a, $b, $epsilon = 0.00001) 
    {
        return abs($a - $b) < $epsilon;
    }

    /**
     * 判断一个浮点数是否大于另一个浮点数
     *
     * @param float|string $a 要比较的第一个操作数
     * @param float|string $b 要比较的第一个操作数
     * @param float $precision 精度
     * @return bool
     *
     */
    public static function isFloatBigger($a, $b, $precision = 0.0001) 
    {
        return !static::isFloatEqual($a, $b, $precision) && ($a > $b);
    }

    /**
     * 判断一个浮点数是否小于另一个浮点数
     *
     * @param float|string $a 要比较的第一个操作数
     * @param float|string $b 要比较的第一个操作数
     * @param float $precision 精度
     * @return bool
     *
     */
    public static function isFloatLess($a, $b, $precision = 0.0001) 
    {
        return !static::isFloatEqual($a, $b, $precision) && ($a < $b);
    }
}
