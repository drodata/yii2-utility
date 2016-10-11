<?php

namespace drodata\adminlte;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This widget is created to render custom tabs in
 * https://almsaeedstudio.com/themes/AdminLTE/pages/UI/general.html
 *
 * Added: `toggleTab` in `items` element
 *
 * Examples:
 * 
 * ```php
 * <?= Tabs::widget([
 *     'options' => ['class' => 'pull-right'],
 *     'items' => [
 *         [
 *             'label' => Html::icon('file') . 'Active Orders',
 *             'toggleTab' => false,
 *             'encode' => false,
 *             'headerOptions' => ['class' => 'pull-left header'],
 *         ],
 *     ],
 * ]) ?>
 * 
 * <?= Tabs::widget([
 *     'items' => [
 *         [
 *             'label' => 'Unpaid' . Html::tag('span', 3, ['class' => 'badge']),
 *             'active' => true,
 *             'encode' => false,
 *             'content' => 'gHello',
 *         ],
 *         [
 *             'label' => Html::a(Html::icon('cog'), '#', ['class' => 'text-muted']),
 *             'encode' => false,
 *             'toggleTab' => false,
 *             'headerOptions' => ['class' => 'pull-right'],
 *         ],
 *     ],
 * ]) ?>
 * ```
 */

class Tabs extends \yii\bootstrap\Tabs
{

    /**
     *
     */
    protected function renderItems()
    {
        $headers = [];
        $panes = [];

        if (!$this->hasActiveTab() && !empty($this->items)) {
            $this->items[0]['active'] = true;
        }

        foreach ($this->items as $n => $item) {
            if (!ArrayHelper::remove($item, 'visible', true)) {
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $headerOptions = array_merge($this->headerOptions, ArrayHelper::getValue($item, 'headerOptions', []));
            $linkOptions = array_merge($this->linkOptions, ArrayHelper::getValue($item, 'linkOptions', []));

            if (isset($item['items'])) {
                $label .= ' <b class="caret"></b>';
                Html::addCssClass($headerOptions, ['widget' => 'dropdown']);

                if ($this->renderDropdown($n, $item['items'], $panes)) {
                    Html::addCssClass($headerOptions, 'active');
                }

                Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle']);
                if (!isset($linkOptions['data-toggle'])) {
                    $linkOptions['data-toggle'] = 'dropdown';
                }
				/** @var Widget $dropdownClass */
				$dropdownClass = $this->dropdownClass;
                $header = Html::a($label, "#", $linkOptions) . "\n"
                    . $dropdownClass::widget(['items' => $item['items'], 'clientOptions' => false, 'view' => $this->getView()]);
            } else {
                $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
                $options['id'] = ArrayHelper::getValue($options, 'id', $this->options['id'] . '-tab' . $n);

                Html::addCssClass($options, ['widget' => 'tab-pane']);
                if (ArrayHelper::remove($item, 'active')) {
                    Html::addCssClass($options, 'active');
                    Html::addCssClass($headerOptions, 'active');
                }

                if (isset($item['url'])) {
                    $header = Html::a($label, $item['url'], $linkOptions);
                } elseif (isset($item['toggleTab'])) {
                    // customize
                    $header = $label;
                } else {
                    if (!isset($linkOptions['data-toggle'])) {
                        $linkOptions['data-toggle'] = 'tab';
                    }
                    $header = Html::a($label, '#' . $options['id'], $linkOptions);
                }

                if ($this->renderTabContent) {
                    $tag = ArrayHelper::remove($options, 'tag', 'div');
                    $panes[] = Html::tag($tag, isset($item['content']) ? $item['content'] : '', $options);
                }
            }

            $headers[] = Html::tag('li', $header, $headerOptions);
        }

        return Html::tag('ul', implode("\n", $headers), $this->options)
        . ($this->renderTabContent ? "\n" . Html::tag('div', implode("\n", $panes), ['class' => 'tab-content']) : '');
    }
}

