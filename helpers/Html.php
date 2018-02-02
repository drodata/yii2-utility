<?php

namespace drodata\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\bootstrap\BaseHtml;
use yii\base\InvalidConfigException;

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

        if (in_array('btn', $classes) && in_array('disabled', $classes) && isset($title)) {
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

    /**
     * Assemble a lite table using just data array.
     *
     * @param array $rows array of row data, the first element is table head,
     * and other is body element, e.g.
     * 
     * ```php
     * echo Html::liteTable([
     *     ['Name', 'Age'],
     *     ['Jack', '18'],
     *     ['Jim', '23'],
     * ]);
     * ```
     *
     * @param string | null $class the `class` value of table.
     * @return string
     */
    public static function liteTable($rows, $class = null) 
    {
        $class = is_null($class) ? "table table-striped table-bordered" : $class;
        $headers = array_shift($rows);
        $headSlice = $bodySlice = [];

        foreach ($headers as $head) {
            $headSlice[] = Html::tag('th', $head);
        }
        $thead = Html::tag('thead', Html::tag('tr', implode("\n", $headSlice)));

        foreach ($rows as $row) {
            $rowSlice = [];
            foreach ($row as $cell) {
                $rowSlice[] = Html::tag('td', $cell);
            }
            $bodySlice[] = Html::tag('tr', implode("\n", $rowSlice));
        }
        $tbody = Html::tag('tbody', implode("\n", $bodySlice));

        return Html::tag('table', $thead . $tbody, [
            'class' => $class,
        ]);
    }

    /**
     * A quick way to to generate a popover helper icon.
     *
     * @param string $content markdown-enabled content
     * @param array $attrs the following attributes are available:
     * 
     * - string `icon` : font-awesome icon name, defaults to 'question-circle-o'
     * - string `title` : popover title
     * - string `direction` : popover direction, defaults to `top`
     *
     * @since 1.0.16
     */
    public static function popoverIcon($content, $attrs = [])
    {
        $icon = ArrayHelper::remove($attrs, 'icon', 'question-circle-o');
        $direction = ArrayHelper::remove($attrs, 'direction', 'top');
        $title = ArrayHelper::remove($attrs, 'title', '');

        return Html::icon($icon, [
            'class' => 'text-info',
            'data' => [
                'toggle' => 'popover',
                'trigger' => 'click hover',
                'html' => true,
                'container' => 'body',
                'placement' => "auto $direction",
                'title' => $title,
                'content' => Markdown::process($content),
            ],
        ]);
    }

    /**
     * A quick way to generate an icon with tooltip. 
     * This method is mainly used in disabled action column button of gridview.
     * For exampel,
     * 
     * ```php
     * // muted icon
     * echo Html::tooltipIcon('Please confirm deletion', 'trash');
     *
     * // red icon
     * echo Html::tooltipIcon('Your order was locked', 'lock', [
     *     'class' => 'text-danger',
     * ]);
     * ```
     * 
     * @param string $tooltip tooltip message
     * @param string $icon font-awesome icon name
     * @param array $options other html options for icon tag. 
     *
     * @since 0.5.6
     *
     */
    public static function tooltipIcon($tooltip, $icon, $options = [])
    {
        $class = ArrayHelper::remove($options, 'class', 'text-muted');

        return Html::icon($icon, [
            'title' => $tooltip,
            'class' => $class,
            'data' => [ 'toggle' => 'tooltip'],
        ]);
    }

    /**
     * Print a variable in browser friendly.
     *
     * @return string print result in string format.
     *
     */
    public static function printR($var)
    {
        return static::tag('pre', print_r($var, true));
    }

    /**
     * A shorthand to render a cancel button.
     *
     * @return string 
     *
     */
    public static function cancelButton()
    {
        return Html::a('取消', Yii::$app->request->referrer, [
            'class' => 'btn btn-default',
        ]);
    }

    /**
     *
     * A quick way to generate a action link, this method is mainly used
     * in action column of grid view and list view.
     * 
     * @param string|array $url link url
     * @param array $options link html options, the follow special attributes are available:
     *     - `type`: string, link type, 'icon' or 'button'
     *     - `title`: string, link text
     *     - `visible` (optional): bool,
     *     - `disabled` (optional): bool, whether to disable button
     *     - `disabledHint` (optional): string, only meaningful when `disabled` is `true`.
     *     - `icon` (optional): string, fa icon name
     *     - `hideIcon` (optional, defaults to `false`): bool, whether to use only the `title` option as link text
     *     - `size` (optional): string, button size, 'sm' (D), 'lg' etc,
     *     - `color` (optional): string, button color, 'primary' (D) and others, add colorfull class name (e.g. `'class' => 'text-red'`)
     *       to generate a colorful action link.
     * 
     * Examples:
     * 
     * ```php
     * 
     * // icon version (in grid view)
     * echo Html::actionLink(['view', 'id' => 3], [
     *     'title' => 'view order',
     *     'icon' => 'eye',
     *     'disabled' => true,
     *     'disabledHint' => 'You are not allowd to view.',
     * ]);
     * 
     * // button version
     * echo Html::actionLink(['view', 'id' => 3], [
     *     'type' => 'button',
     *     'title' => 'Delete',
     *     'icon' => 'trash',
     *     'hideIcon' => true,
     *     'color' => 'danger',
     *     'disabled' => true,
     *     'disabledHint' => 'You are not allowd to view.',
     * ]);
     * ```
     *
     * @since 1.0.16
     */
    public static function actionLink($url, $options)
    {
        if ($url !== null) {
            $options['href'] = Url::to($url);
        }
        $visible = ArrayHelper::remove($options, 'visible', true);
        $disabled = ArrayHelper::remove($options, 'disabled', false);
        $disabledHint = ArrayHelper::remove($options, 'disabledHint');
        $type = ArrayHelper::remove($options, 'type', 'icon');
        $icon = ArrayHelper::remove($options, 'icon');
        $hideIcon = ArrayHelper::remove($options, 'hideIcon', false);
        $size = ArrayHelper::remove($options, 'size', 'sm');
        $color = ArrayHelper::remove($options, 'color', 'primary');

        $class = ArrayHelper::getValue($options, 'class', '');
        $title = ArrayHelper::getValue($options, 'title');

        if (!$visible) {
            return '';
        }


        if ($type == 'icon') {
            $text = (empty($icon) || $hideIcon) ? $title : static::icon($icon);

            if ($disabled) {
                if (empty($icon) || $hideIcon) {
                    return static::tag('span', $text, [
                        'title' => $disabledHint,
                        'class' => 'text-muted',
                        'data-toggle' => 'tooltip',
                    ]);
                } else {
                    return static::icon($icon, [
                        'title' => $disabledHint,
                        'class' => 'text-muted',
                        'data-toggle' => 'tooltip',
                    ]);
                }
            }

            if ($color != 'primary') {
                $options['class'] .= " text-$color";
            }

            return static::a($text, $url, $options);
        } elseif ($type == 'button') {
            $class .= " btn btn-$color" 
                . ($size ? " btn-$size" : '')
                . ($disabled ? " disabled" : '');
            if ($disabled) {
                $options['title'] = $disabledHint;
            }
            $options['class'] = $class;

            $text = (empty($icon) || $hideIcon) ? '' : static::icon($icon);
            $text .= $title;

            return static::a($text, $url, $options);
        }
    }
}
