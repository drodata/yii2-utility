<?php

namespace drodata\adminlte;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use drodata\helpers\Html;

/**
 * Usage sample:
 *
 * ```php
 * echo \drodata\adminlte\TodoTabs::widget([
 *     'configs' => [
 *         [
 *             'unpaid', 'Unpaid', '/order/_grid-tab', [],
 *             Order::find()->unpaid(),
 *             true
 *         ],
 *         [
 *             'paid', 'Paid', '/order/_grid-tab', ['tab' => 'paid'],
 *             Order::find()->paid(),
 *             true
 *         ],
 *     ],
 * ]);
 * ```
 */
class TodoTabs extends \yii\bootstrap\Widget
{
    public $configs;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $items = $this->generateItems();

        return Html::tag('div', Tabs::widget([ 'items' => $items]), ['class' => 'nav-tabs-custom']);
    }

    protected function generateItems()
    {
        $items = [];

        if (!is_array($this->configs) || empty($this->configs)) {
            throw new InvalidConfigException("The 'configs' option shoud be an array.");
        }

        foreach ($this->configs as $list) {
            list($tab, $label, $view, $viewParams, $query, $visible) = $list;
            if (!$visible) {
                continue;
            }
            $dp = new ActiveDataProvider([
                'query' => $query,
                'pagination' => false,
                'sort' => false,
            ]);
            $badge = Html::tag('span', $dp->totalCount == 0 ? '' : $dp->totalCount, ['class' => 'badge']);

            $viewParams = ArrayHelper::merge($viewParams, [
                'dataProvider' => $dp,
            ]);

            $items[] = [
                'label' => $label . $badge,
                'encode' => false,
                'active' => $_GET['tab'] == $tab ? true : false,
                'content' => $this->render($view, $viewParams),
                'visible' => $visible,
            ];
        }
        
        if (!$_GET['tab']) {
            $items[0]['active'] = true;
        }

        return $items;
    }
}
