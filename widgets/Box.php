<?php
namespace drodata\widgets;

use Yii;
use drodata\helpers\Html;

class Box extends \yii\bootstrap\Widget
{
    public $style = 'default';
    public $solid = false;
    public $title = '';
    public $content = '';
    public $footer = null;
    public $tools = [];
    public function init()
    {
        parent::init();
        
        $boxClassNames = ['box'];
        $boxClassNames[] = 'box-' . $this->style;
        if ($this->solid) {
            $boxClassNames[] = 'box-solid';
        }
        $opt  = Html::beginTag('div', ['class' => implode(' ', $boxClassNames)]);

        // header
        $opt  .= Html::beginTag('div', ['class' => 'box-header with-border']);
        $opt  .= Html::tag('h3', $this->title, ['class' => 'box-title']);

        if (count($this->tools) > 0) {
            $predefinedBtns = [
                'collapse' => Html::button(Html::icon('minus'), [
                        'class' => 'btn btn-box-tool',
                        'title' => '折叠',
                        'data' => [
                            'widget' => 'collapse',
                            'toggle' => 'tooltip',
                        ],
                    ]),
                'remove' => Html::button(Html::icon('times'), [
                        'class' => 'btn btn-box-tool',
                        'title' => '移除',
                        'data' => [
                            'widget' => 'remove',
                            'toggle' => 'tooltip',
                        ],
                    ]),
                'return' => Html::a(
                    Html::icon('arrow-left'),
                    Yii::$app->request->referrer,
                    [
                        'class' => 'btn btn-box-tool',
                        'title' => '返回',
                        'data' => [
                            'toggle' => 'tooltip',
                        ],
                    ]
                ),
            ];
            for ($i = 0; $i < count($this->tools); $i++) {
                $alias = $this->tools[$i];
                if (isset($predefinedBtns[$alias])) {
                    $this->tools[$i] = $predefinedBtns[$alias];
                }
            }
            $opt  .= Html::beginTag('div', ['class' => 'box-tools pull-right']);
            $opt .= implode('', $this->tools);
            $opt  .= Html::endTag('div');
        }
        $opt  .= Html::endTag('div');

        // body
        $opt  .= Html::beginTag('div', ['class' => 'box-body']);

        echo $opt;
    }
    public function run()
    {
        $content = empty($this->content) ? '' : $this->content;

        $tail = Html::endTag('div'); // .box-body 
        if (!empty($this->footer)) {
            $tail  .= Html::tag('div', $this->footer, ['class' => 'box-footer']);
        }
        $tail .= Html::endTag('div'); // .box ends

        return $content . $tail;
    }
}
