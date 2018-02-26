<?php

namespace drodata\widgets;

use Yii;
use yii\helpers\Url;
use drodata\models\Currency;
use drodata\models\Rate;
use drodata\helpers\Html;
use drodata\adminlte\InfoBox;

/**
 * Sample:
 *
 * echo \drodata\widgets\RateInfoBox::widget([
 *     'currencyCode' => 'USD',
 * ]);
 *
 */
class RateInfoBox extends InfoBox
{
    /**
     * 货币代码，值为 `currency.code` 中的有效值
     */
    public $currencyCode;

    public function init()
    {
        parent::init();
        $currency = Currency::findOne(['code' => $this->currencyCode]);
        $this->text = "当前{$currency->name}汇率";
        $this->icon = 'exchange';

        // 仅当使用外币时才显示 info box
        $this->visible = $this->currencyCode != 'CNY';

        $rate = Rate::find()->where(['currency' => $this->currencyCode])->orderBy('date DESC')->one();

        if (empty($rate)) {
            $this->number = '尚未设置';
            $this->operation = Html::a('现在设置', Url::to(['/rate/create', 'date' => date('Y-m-d'), 'currency' => $this->currencyCode]));
        } else {
            $this->number = $rate->value;
            $action = date('Y-m-d') == $rate->date ? 'update' : 'create';

            $this->operation =  Html::tag('i', "于{$rate->date}设置")
                . Html::a('更改', Url::to(["/rate/$action", 'date' => date('Y-m-d'), 'currency' => $this->currencyCode]));
        }

    }
}
