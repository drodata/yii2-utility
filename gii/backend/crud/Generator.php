<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace drodata\gii\backend\crud;

use Yii;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\db\Schema;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use yii\helpers\StringHelper;
use yii\web\Controller;

/**
 * Generates CRUD
 *
 * @property array $columnNames Model column names. This property is read-only.
 * @property string $controllerID The controller ID (without the module ID prefix). This property is
 * read-only.
 * @property array $searchAttributes Searchable attributes. This property is read-only.
 * @property boolean|\yii\db\TableSchema $tableSchema This property is read-only.
 * @property string $viewPath The controller view path. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\crud\Generator
{
    /**
     * @var boolean 当屏幕变小时，是否将 index 页面中的 GridView 转换成 ListView
     */
    public $enableResponsive = false;

    /**
     * @var string 模型中文名称
     */
    public $modelNameCn;


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return "Drodata's CRUD Generator";
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return '支持是否显示手机端 responsive';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['modelNameCn'], 'filter', 'filter' => 'trim'],
            [['enableResponsive'], 'boolean'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'enableResponsive' => '针对小屏页面生成单独的页面',
            'modelNameCn' => '模型中文名称',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'enableResponsive' => '哈哈哈',
            'modelNameCn' => '类似 table comment 功能',
        ]);
    }

    /**
     * 与原方法相比的不同：
     *
     * - 仅使用 ColumnSchema 中的 dbType 判断
     * - 添加两个特殊的格式 'lookup' and 'fk', 前者表示使用字典存储的枚举类型值; 后者表示外键，在生成表单时尝使用下拉菜单选择
     *
     * @param \yii\db\ColumnSchema $column
     * @return string
     */
    public function generateColumnFormat($column)
    {
        if (strpos($column->dbType, 'tinyint(1)') !== false || in_array($column->name, ['action'])) {
            return 'lookup';
        }
        if (stripos($column->name, '_id') !== false) {
            // '_id' 结尾的通常是外键
            return 'fk';
        }
        if (strpos($column->dbType, 'date') !== false || in_array($column->name, ['created_at', 'updated_at'])) {
            return 'datetime';
        }
        if (strpos($column->dbType, 'decimal') !== false) {
            return 'decimal';
        }
        if (
            strpos($column->dbType, 'int') !== false 
            && stripos($column->name, '_id') === false
            && $column->name != 'id'
        ) {
            return 'integer';
        }
        if (strpos($column->dbType, 'text') !== false) {
            return 'ntext';
        }
        if (stripos($column->name, 'email') !== false) {
            return 'email';
        }
        if (preg_match('/(\b|[_-])url(\b|[_-])/i', $column->name)) {
            return 'url';
        }
        return 'text';
    }
    /**
     * Generates code for active field
     * @param string $attribute
     * @return string
     */
    public function generateActiveField($attribute)
    {
        $column = $this->getTableSchema()->columns[$attribute];
        $format = $this->generateColumnFormat($column);

        switch ($format) {
            case 'lookup':
                $lookupType = $this->assembleLookupType($column);
                return "\$form->field(\$model, '$attribute')->inline()->radioList(Lookup::items('$lookupType'))";
                break;
            case 'fk':
                return <<<EOF
\$form->field(\$model, '$attribute')->widget(Select2::classname(), [
        'data' => [],
        'options' => ['placeholder' => '请选择'],
        'addon' => [ ],
    ])
EOF;
                break;
            case 'integer':
                return "\$form->field(\$model, '$attribute')->input('number', ['step' => 1])";
                break;
            case 'datetime':
                return "\$form->field(\$model, '$attribute')->input('date', [])";
                break;
            case 'decimal':
                return "\$form->field(\$model, '$attribute')->input('number', ['step' => 0.01])";
                break;
            case 'ntext':
                return "\$form->field(\$model, '$attribute')->textArea(['rows' => 3, 'placeholder' => '选填'])";
                break;
            case 'text':
                return "\$form->field(\$model, '$attribute')->textInput(['maxlength' => true])";
                break;
        }
    }

    /**
     * 根据模型名称和列明拼装出对应的 `lookup.type` 值
     * GridView, DetailView 等都需要该值. 假设表名是 order, 列名是 'payment_way',
     * 经过此方法返回的字符串是 'OrderPaymentWay', 对应订单结算方式存储在字典表内的 type 列。
     *
     * @param \yii\db\ColumnSchema $column
     * @return string
     */
    public function assembleLookupType($column)
    {
        $modelClass = StringHelper::basename($this->modelClass);
        $slices = explode('_', $column->name);
        $slices = array_map('ucfirst', $slices);

        return $modelClass . implode('', $slices);
    }

    /**
     * 加入特殊的 datetime 列区间筛选
     *
     * @return array the generated validation rules
     */
    public function generateSearchRules()
    {
        if (($table = $this->getTableSchema()) === false) {
            return ["[['" . implode("', '", $this->getColumnNames()) . "'], 'safe']"];
        }

        $types = [];

        foreach ($table->columns as $column) {
            // 较原代码改动开始
            $format = $this->generateColumnFormat($column);
            if ($format == 'datetime') {
                $types['dateRange'][] = $column->name;
            } elseif (in_array($format, ['lookup', 'fk', 'integer'])) {
                $types['integer'][] = $column->name;
            } elseif ($format == 'decimal') {
                $types['number'][] = $column->name;
            } else {
                $types['safe'][] = $column->name;
            }
            // 较原代码改动结束
        }

        $rules = [];
        foreach ($types as $type => $columns) {
            if ($type == 'dateRange') {
                $rules[] = "[['" . implode("', '", $columns) . "'], DateRangeValidator::classname()]";
            } else {
                $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
            }
        }

        return $rules;
    }
    /**
     * Generates search conditions
     * @return array
     */
    public function generateSearchConditions()
    {
        $columns = [];
        if (($table = $this->getTableSchema()) === false) {
            $class = $this->modelClass;
            /* @var $model \yii\base\Model */
            $model = new $class();
            foreach ($model->attributes() as $attribute) {
                $columns[$attribute] = 'unknown';
            }
        } else {
            foreach ($table->columns as $column) {
                // 源代码是 name->column type 映射，这里改为 name -> format 映射
                $columns[$column->name] = $this->generateColumnFormat($column);
            }
        }

        $likeConditions = [];
        $hashConditions = [];
        $rangeConditions = [];
        foreach ($columns as $column => $format) {
            if ($format == 'datetime') {
                $rangeConditions[] = <<<EOF
->andFilterWhere(['between', '$column', empty(\$this->$column) ? '' : strtotime(explode('-', \$this->$column)[0] . ' 00:00:00'), empty(\$this->$column) ? '' : strtotime(explode('-', \$this->$column)[1] . ' 23:59:59')])
EOF;
            } elseif (in_array($format, ['lookup', 'fk', 'integer', 'decimal'])) {
                $hashConditions[] = "'{$column}' => \$this->{$column},";
            } else {
                $likeKeyword = $this->getClassDbDriverName() === 'pgsql' ? 'ilike' : 'like';
                $likeConditions[] = "->andFilterWhere(['{$likeKeyword}', '{$column}', \$this->{$column}])";                    
            }
        }

        $conditions = [];
        if (!empty($hashConditions)) {
            $conditions[] = "\$query->andFilterWhere([\n"
                . str_repeat(' ', 12) . implode("\n" . str_repeat(' ', 12), $hashConditions)
                . "\n" . str_repeat(' ', 8) . "]);\n";
        }
        if (!empty($rangeConditions)) {
            $conditions[] = "\$query" . implode("\n" . str_repeat(' ', 12), $rangeConditions) . ";\n";
        }
        if (!empty($likeConditions)) {
            $conditions[] = "\$query" . implode("\n" . str_repeat(' ', 12), $likeConditions) . ";\n";
        }

        return $conditions;
    }

    public function printTableSchema()
    {
        echo "\n<pre>";
        print_r($generator->getTableSchema());
        echo "</pre>\n";
    }
}
