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
    /**
     * 根据主键生成 actionLink() 中的路由字符串
     */
    public function generateActionLinkRoute()
    {
        $class = $this->ns . '\\' . $this->modelClass;
        $pks = $class::primaryKey();

        $slices = [];
        foreach ($pks as $key) {
            $slices[] = "'$key' => \$this->$key";
        }
        $str = implode(', ', $slices);

        return "[\$route, $str]";
    }
}
