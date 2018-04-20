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
}
