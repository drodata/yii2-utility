<?php
namespace drodata\editable;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Generic Editable column submit action
 *
 * ```php
 * public function actions()
 * {
 *     return [
 *         // ...
 *         'submit-editable' => [
 *             'class' => 'drodata\editable\SubmitAction',
 *         ],
 *     ];
 * }
 * ```
 */
class SubmitAction extends \yii\base\Action
{
    /**
     * {@inheritdoc}
     *
     * @param string $modelClass fully-qualified model class name
     * @param string $column column name
     * @param int $lookup 是否输出转换的值，适用那些使用字典模型的列
     */
    public function run($modelClass, $column, $lookup)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $column = Yii::$app->request->get('column');
        $record = $this->findModel();

        if (empty($record)) {
            return [
                'output' => '',
                'message' => "$modelClass does not exist.",
            ];
        }

        $record->updateAttributes([
            $column => Yii::$app->request->post($column),
        ]);

        $output = null;

        if ($lookup === '1') {
            $output = $record->lookup($column);
        } elseif (method_exists($record, 'getReadableAttribute')) {
            $output = $record->getReadableAttribute($column);
        }

        return [
            'output' => $output,
            'message' => '',
        ];
    }

    protected function findModel()
    {
        $modelClass = Yii::$app->request->get('modelClass');

        $primayKeys = $modelClass::primaryKey();
        $pairs = [];
        foreach ($primayKeys as $name) {
            $pairs[$name] = Yii::$app->request->get($name);
        }

        return $modelClass::findOne($pairs);
    }
}
