<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace drodata\gii\backend\model;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\Schema;
use yii\db\TableSchema;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\base\NotSupportedException;

/**
 * This generator will generate one or multiple ActiveRecord classes for the specified database table.
 *
 * @author drodata <chnkui@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\model\Generator
{
    public $baseClass = 'drodata\db\ActiveRecord';

    /**
     * @var boolean 是否有子条目，true 时将自动插入 getItemsDataProvider() 等代码模板
     */
    public $hasItems = false;

    /**
     * @var boolean 使用采用 ajax submit 方式提交表单，true 时将自动插入一段 ajaxSubmit 代码模板
     */
    public $ajaxSubmit = false;
    /**
     * 生成 AR::actionLink() 中路由所需的主键参数字符串。例如，对使用 'id' 作为主键的表来说，返回值为 `'id' => $this->id`; 
     * 对使用 `date` 和 `currency` 复合主键来说，返回 `'date' => $this->id, 'currency' => $this->currency`
     *
     * @return string
     */
    public function generatePrimayKeyParamString($tableName)
    {
        $schema = $this->getDbConnection()->getTableSchema($tableName);
        $slices = [];
        foreach ($schema->primaryKey as $key) {
            $slices[] = "'$key' => \$this->$key";
        }

        return implode(', ', $slices);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['hasItems', 'ajaxSubmit'], 'boolean'],
        ]);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'hasItems' => '模型内包含子条目',
            'ajaxSubmit' => 'Ajax submit',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'hasItems' => '勾选将自动生成相关代码模板',
            'ajaxSubmit' => '通过 ajax submit 方式提交表单',
        ]);
    }
}
