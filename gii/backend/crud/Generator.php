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
     * @param \yii\db\ColumnSchema $column
     * @return string
     */
    public function generateColumnFormat($column)
    {
        if (strpos($column->dbType, 'date') !== false || in_array($column->name, ['created_at', 'updated_at'])) {
            return 'datetime';
        }
        if (
            strpos($column->dbType, 'decimal') !== false 
            || in_array($column->name, ['amount', 'quantity', 'weight'])
        ) {
            return 'decimal';
        }
        if (strpos($column->dbType, 'text') !== false) {
            return 'ntext';
        }
        if (strpos($column->dbType, 'tinyint(1)') !== false || in_array($column->name, ['action'])) {
            return 'lookup';
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
