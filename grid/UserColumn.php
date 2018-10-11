<?php

namespace drodata\grid;

use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * UserColumn makes User related column showing simple.
 *
 * First of all, config option `modelClass` and `targetAttribute` in bootstrap step as following:
 * 
 * ```
 * in backend/bootstrap.php
 * 
 * \Yii::$container->set('drodata\grid\UserColumn', [
 *     'modelClass' => 'backend\models\User',
 *     'targetAttribute' => 'display_name',
 * ]);
 * ```
 *
 * Usage example in 'columns' option of GridView widget:
 *
 * ```
 * 'columns' => [
 *     [
 *         'class' => 'drodata\grid\UserColumn',
 *         'attribute' => 'created_by',
 *     ],
 *     [
 *         'class' => 'drodata\grid\UserColumn',
 *         'attribute' => 'updated_by',
 *     ],
 * ]
 * ```
 * @author drodata <chnkui@gmail.com>
 */
class UserColumn extends \yii\grid\DataColumn
{
    /**
     * @var string AR 类名
     */
    public $modelClass;
    /**
     * @var string $modelClass 对应的表格上需要显示的列名称，例如 'username', 'display_name'
     */
    public $targetAttribute;

    public function init()
    {
        if ($this->modelClass === null) {
            throw new InvalidConfigException(get_class($this) . '::$modelClass must be set.');
        }
    }

    public function getDataCellValue($model, $key, $index)
    {
        $modelClass = $this->modelClass;
        $map = ArrayHelper::map($modelClass::find()->asArray()->all(), 'id', $this->targetAttribute);

        $value = ArrayHelper::getValue($model, $this->attribute);
        return $map[$value];
    }
}
