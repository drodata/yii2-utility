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
     * - 在最前面添加特殊的格式 'lookup', 表示使用字典存储的枚举类型值
     *
     * @param \yii\db\ColumnSchema $column
     * @return string
     */
    public function generateColumnFormat($column)
    {
        if (strpos($column->dbType, 'tinyint(1)') !== false || in_array($column->name, ['action'])) {
            return 'lookup';
        }
        if (strpos($column->dbType, 'date') !== false || in_array($column->name, ['created_at', 'updated_at'])) {
            return 'datetime';
        }
        if (strpos($column->dbType, 'decimal') !== false) {
            return 'decimal';
        }
        // '_id' 结尾的通常是外键，不需要使用 integer 格式
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
}
