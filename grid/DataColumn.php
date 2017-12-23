<?php

namespace drodata\grid;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use drodata\helpers\Html;
use kartik\select2\Select2;

class DataColumn extends \yii\grid\DataColumn
{
    /**
     * @var bool 是否使用 Select widget 显示下拉菜单
     */
    public $select2 = false;

    /**
     * 在 yii\grid\DataColumn 上做的唯一一处改动就是用 $this->select2 开关控制
     * 是否使用 Select2 widget 替换掉传统的下拉菜单
     *
     */
    protected function renderFilterCellContent()
    {
        if (is_string($this->filter)) {
            return $this->filter;
        }
        $model = $this->grid->filterModel;
        if ($this->filter !== false && $model instanceof Model && $this->attribute !== null && $model->isAttributeActive($this->attribute)) {
            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = ' ' . Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }
            if (is_array($this->filter)) {
                $options = array_merge(['prompt' => ''], $this->filterInputOptions);
                // 改动处
                if ($this->select2) {
                    return Select2::widget([
                        'model' => $model,
                        'attribute' => $this->attribute,
                        'data'=> $this->filter,
                        'options'=> $options,
                    ]);
                } else {
                    return Html::activeDropDownList($model, $this->attribute, $this->filter, $options) . $error;
                }
            } elseif ($this->format === 'boolean') {
                $options = array_merge(['prompt' => ''], $this->filterInputOptions);
                return Html::activeDropDownList($model, $this->attribute, [
                    $this->grid->formatter->booleanFormat[0],
                    $this->grid->formatter->booleanFormat[1],
                ], $options) . $error;
            }
            return Html::activeTextInput($model, $this->attribute, $this->filterInputOptions) . $error;
        }
        return parent::renderFilterCellContent();
    }
}
