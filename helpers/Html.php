<?php
namespace drodata\helpers;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\BaseHtml;

/**
 * customize icon() method, with font awesome enabled
 *
 * @author drodata@foxmail.com
 * @since 1.0.14
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
     * Feature:
     *
     * - Add the special `visible` attribute
     * - Support build-in tooltip for disabled links
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
        $link = $visible ? static::tag('a', $text, $options) : '';

        if (in_array('disabled', $classes) && isset($title)) {
            $link = static::tag('span', $link, [
                'data' => [
                    'toggle' => 'tooltip',
                    'title' => $title,
                ],
            ]);
        }

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
        return $visible ? static::tag('button', $content, $options) : '';
    }
}
