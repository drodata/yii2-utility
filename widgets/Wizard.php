<?php

namespace drodata\widgets;

use drodata\helpers\Html;

/**
 * 向导是 drodata\widgets\Box widget 的子类，特点是主内容区域有几个负责导航的按钮链接,
 * 这些链接放在 navigation wrapper 内。使用范例：
 *
 * ```php
 * echo Wizard::widget([
 *     'title' => 'foo',
 *     'content' => 'bar',
 *     'buttons' => [
 *         $model->actionLink('view', ['type' => 'button']),
 *         $model->actionLink('view', ['type' => 'button']),
 *     ],
 * ]);
 * ```
 */
class Wizard extends Box
{
    /**
     * @var array button array
     */
    public $buttons = [];

    /**
     * @var bool wheter to append a home button to $this->buttons
     */
    public $showHomeButton = true;

    /**
     * @var string default home button text
     */
    public $homeButtonText = '返回首页';

    /**
     * @var string array default home button HTML options
     */
    public $homeButtonOptions = ['class' => 'btn btn-default'];

    /**
     * @var string array default navigation wrapper HTML options
     */
    public $navigationOptions = ['class' => 'button-group text-center'];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $navigation = $this->renderNavigationContent();

        $this->content .= $navigation;
    }

    /**
     * Render the navigation content
     * @return string
     */
    protected function renderNavigationContent()
    {
        $homeButton = Html::a($this->homeButtonText, '/', $this->homeButtonOptions);

        if ($this->showHomeButton) {
            array_push($this->buttons, $homeButton);
        }

        return Html::tag('div', implode("\n", $this->buttons), $this->navigationOptions);
    }
}
