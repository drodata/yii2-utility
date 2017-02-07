<?php
namespace drodata\weui;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\BaseHtml;

/**
 * customize icon() method, with font awesome enabled
 *
 * @author drodata@foxmail.com
 * @since 1.0.15
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

    /**
     * Fix-width icon
     */
    public static function fwicon($name, $options = [])
    {
        $tag = ArrayHelper::remove($options, 'tag', 'i');
        $classPrefix = ArrayHelper::remove($options, 'prefix', 'fa fa-fw fa-');
        static::addCssClass($options, $classPrefix . $name);
        return static::tag($tag, '', $options);
    }

    /**
     * Convert weui-style btn to bootstrap-style one
     */
    public static function substitute($class)
    {
        $map = [
            'btn' => 'weui-btn',
            'btn-success' => 'weui-btn_primary',
            'btn-warning' => 'weui-btn_warn',
            'btn-default' => 'weui-btn_default',
        ];
        $classes = array_map('trim', explode(' ', $class));

        for ($i =0; $i < count($classes); $i++) {
            $key = $classes[$i];
            if (array_key_exists($key, $map)) {
                $classes[$i] = $map[$key];
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Feature:
     *
     * - Add the special `visible` attribute
     *
     */
    public static function a($text, $url = null, $options = [])
    {
        if ($url !== null) {
            $options['href'] = Url::to($url);
        }
        $classes = explode(' ', ArrayHelper::getValue($options, 'class', ''));
        $classes = array_map('trim', $classes);
        $title = ArrayHelper::getValue($options, 'title');
        $visible = ArrayHelper::remove($options, 'visible', true);

        // convert btn class style (weui to bootstrap)
        $originalClass = ArrayHelper::remove($options, 'class');
        if (!empty($originalClass)) {
            $options = ArrayHelper::merge($options, [
                'class' => static::substitute($originalClass),
            ]);
        }

        $link = $visible ? static::tag('a', $text, $options) : '';
        return $link;
    }


    /**
     * Add the special `visible` attribute
     */
    public static function button($content = 'Button', $options = [])
    {
        if (!isset($options['type'])) {
            $options['type'] = 'button';
        }
        $visible = ArrayHelper::remove($options, 'visible', true);

        // convert btn class style (weui to bootstrap)
        $originalClass = ArrayHelper::remove($options, 'class');
        if (!empty($originalClass)) {
            $options = ArrayHelper::merge($options, [
                'class' => static::substitute($originalClass),
            ]);
        }

        return $visible ? static::tag('button', $content, $options) : '';
    }
}
