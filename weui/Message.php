<?php

namespace drodata\weui;

use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 *
 * ```php
 * echo Message::widget([
 *     'icon' => 'success',
 *     'msg' => [
 *         'title' => 'Operation Sucess',
 *         'desc' => 'Hello world',
 *     ],
 *     'btnPrimary' => Html::a('OK', '#', ['class' => 'btn btn-success']),
 *     'btnDefault' => Html::a('Return to Home', '#', ['class' => 'btn btn-default']),
 *     'footer' => [
 *         'link' => [
 *             'url' => '#',
 *             'text' => 'NABP',
 *         ],
 *         'text' => "&copy; 2017",
 *     ],
 *     
 * ]);
 * ```
 */
class Message extends Widget
{
    public $icon = 'success';
    public $msg = [];
    public $btnPrimary = null;
    public $btnDefault = null;
    public $footer = [];

    public function init()
    {
        parent::init();

        if (!isset($this->msg['title'])) {
            $this->msg['title'] = '操作成功';
        }
        if (!isset($this->msg['desc'])) {
            $this->msg['desc'] = '';
        }
        if (!isset($this->footer['link'])) {
            $this->footer['link'] = false;
        }
    }

    public function run()
    {
        echo Html::beginTag('div', ['class' => 'weui-msg']);
        echo $this->renderIcon() . "\n";
        echo $this->renderText() . "\n";
        echo $this->renderOperation() . "\n";
        echo $this->renderFooter() . "\n";
        echo Html::endTag('div');
    }

    protected function renderIcon()
    {
        $iconMap = [
            'success' => 'weui-icon-success',
            'info' => 'weui-icon-info',
            'warning' => 'weui-icon-warn',
            'waiting' => 'weui-icon-waiting',
        ];

        $icon = Html::tag('i', '', [
            'class' => 'weui-icon_msg ' . $iconMap[$this->icon],
        ]);
        return Html::tag('div', $icon, ['class' => 'weui-msg__icon-area']);
    }
    protected function renderText()
    {
        return <<<EOF
<div class="weui-msg__text-area">
    <h2 class="weui-msg__title">{$this->msg['title']}</h2>
    <p class="weui-msg__desc">{$this->msg['desc']}</p>
</div>
EOF;
    }
    protected function renderOperation()
    {
        return <<<EOF
<div class="weui-msg__opr-area">
    <p class="weui-btn-area">
        {$this->btnPrimary}
        {$this->btnDefault}
    </p>
</div>
EOF;
    }
    protected function renderFooter()
    {
        $link = isset($this->footer['link'])
            ? Html::a(
                $this->footer['link']['text'],
                $this->footer['link']['url'],
                ['class' => 'weui-footer__link']
            ) : '';
        return <<<EOF
<div class="weui-msg__extra-area">
    <div class="weui-footer">
        <p class="weui-footer__links">{$link}</p>
        <p class="weui-footer__text">
            {$this->footer['text']}
        </p>
    </div>
</div>
EOF;
    }
}
