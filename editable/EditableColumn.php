<?php

namespace drodata\editable;

use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use drodata\grid\DataColumn;
use kartik\editable\Editable;
use ReflectionClass;

/**
 *
        [
            'class' => 'drodata\editable\EditableColumn',
            'attribute' => 'urgency_level',
            'filter' => Lookup::items('demand-urgency-level'),
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return $model->lookup('urgency_level');
            },
            'contentOptions' => [ 'style' => 'width:80px;min-width:80px' ],
            'editOptions' => [
                'editable' => true,
                'inputType' => 'dropDownList',
                'modelClass' => '\backend\models\Demand',
                'lookup' => 1,
            ],

        ],
    */
class EditableColumn extends DataColumn
{
    /**
     * @var array 存储所有相关配置选项
     *
     * - `editable` bool 是否支持编辑
     * - `inputType` string (default `textInput`) 参考 Editable::$inputType
     * - `modelClass` string fully qualified model class
     * - `column` string column name
     * - `lookup` int(1|0, defaults to 0) 是否返回转换的值(使用 LookupBehavior)
     *
     */
    public $editOptions;

    /**
     * @var string 服务端处理修改动作的路由名称。为避免重复，可在 bootstrap 阶段统一设置
     */
    public $submitRoute;

    public function init()
    {
        parent::init();

        if (empty($this->attribute) || empty($this->attribute)) {
            throw new InvalidConfigException("Both 'attribute' and 'submitRoute' are required.");
        }
    }

    /**
     * {@inheritdoc}
     *
     * 根据 editable option 决定直接显示还是显示 Editable widget
     */
    public function getDataCellValue($model, $key, $index)
    {
        $rawValue = null;
        if ($this->value !== null) {
            $rawValue = is_string($this->value) 
                ? ArrayHelper::getValue($model, $this->value) 
                : call_user_func($this->value, $model, $key, $index, $this);
        } elseif ($this->attribute !== null) {
            $rawValue = ArrayHelper::getValue($model, $this->attribute);
        }

        $editable = ArrayHelper::getValue($this->editOptions, 'editable', true);

        return $editable ? $this->renderEditableColumn($model, $key, $index, $rawValue) : $rawValue;
    }


    /**
     * render editable column 
     * @param string $value raw value of data column
     */
    protected function renderEditableColumn($model, $key, $index, $value)
    {
        $inputType = ArrayHelper::getValue($this->editOptions, 'inputType', 'textInput');
        $valueIfNull = ArrayHelper::getValue($this->editOptions, 'valueIfNull', '未设置');

        $head = ArrayHelper::getValue($this->editOptions, 'head');
        if (empty($head)) {
            $head = $this->label ?: $model->getAttributeLabel($this->attribute);
        }

        switch ($inputType) {
            case Editable::INPUT_DROPDOWN_LIST:
                $data = ArrayHelper::getValue($this->editOptions, 'data', $this->filter);
                if (empty($data)) {
                    throw new InvalidConfigException("Either 'data' or 'filter' is required.");
                }
                break;
            default:
                break;
        }


        $modelClass = ArrayHelper::getValue($this->editOptions, 'modelClass');
        if (empty($modelClass)) {
            throw new InvalidConfigException("The 'modelClass' option is required.");
        }

        $relationSlices = explode('.', $this->attribute);
        $column = array_pop($relationSlices);

        // assemble key pairs
        if (empty($relationSlices)) {
            $pk = $modelClass::primaryKey()[0];
            $pairs = [
                $pk => $key,
            ];
        } else {
            // has relational data. e.g. 'spu.brand.name'
            $relationModel = $model;
            foreach ($relationSlices as $relation) {
                if (empty($relationModel->$relation)) {
                    $relationModel = null;
                    break;
                } else {
                    $relationModel = $relationModel->$relation;
                }
            }

            $pks = $modelClass::primaryKey();
            foreach ($pks as $pk) {
                $pairs[$pk] = $relationModel ? $relationModel->$pk : 0;
            }
        }

        $lookup = ArrayHelper::getValue($this->editOptions, 'lookup', 0);
        $queryString = http_build_query(ArrayHelper::merge($pairs, [
            'modelClass' => $modelClass,
            'column' => $column,
            'lookup' => $lookup,
        ]));

        $configs = [
            'name' => $column,
            'inputType' => $inputType,
            'value' => $value,
            'valueIfNull' => $valueIfNull,
            'formOptions' => [
                'action' => "/{$this->submitRoute}?{$queryString}",
            ],
            'asPopover' => true,
            'header' => $head,
            'data' => $data,
            'options' => [
                'class'=>'form-control',
                'prompt'=>'请选择',
            ],
        ];

        return Editable::widget($configs);
    }
}
