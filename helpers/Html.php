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
     * Shorthand for generating a popover helper icon.
     *
     * @param array $attrs the following attributes are available:
     * 
     * - string `content` (required): markdown-enabled content
     * - string `icon` (optional): font-awesome icon name, defaults to 'question-circle-o'
     * - string `title` (optional): popover title
     * - string `direction` (optional): popover direction, defaults to `top`
     *
     * @since 1.0.16
     */
    public static function popoverHelper($attrs)
    {
        $icon = ArrayHelper::remove($attrs, 'icon', 'question-circle-o');
        $direction = ArrayHelper::remove($attrs, 'direction', 'top');
        $title = ArrayHelper::remove($attrs, 'title', '');

        $content = Markdown::process(ArrayHelper::remove($attrs, 'content'));

        return Html::icon($icon, [
            'class' => 'text-info',
            'data' => [
                'toggle' => 'popover',
                'trigger' => 'click hover',
                'html' => true,
                'container' => 'body',
                'placement' => "auto $direction",
                'title' => $title,
                'content' => $content,
            ],
        ]);
    }
}
