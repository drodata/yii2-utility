<?php
namespace yii\bootstrap;
use yii\helpers\ArrayHelper;
/**
 * customize icon() method, with font awesome enabled
 *
 * @author drodata@foxmail.com
 * @since 1.0.11
 */
class Html extends BaseHtml
{
    public static function icon($name, $options = [])
    {
        $tag = ArrayHelper::remove($options, 'tag', 'i');
        $classPrefix = ArrayHelper::remove($options, 'prefix', 'fa fa-');
        static::addCssClass($options, $classPrefix . $name);
        return static::tag($tag, '', $options);
    }
}
