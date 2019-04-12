<?php
/**
 * This is the template for generating the model class of a specified table.
 */

use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use drodata\helpers\Html;
use drodata\helpers\Utility;
use drodata\behaviors\TimestampBehavior;
use drodata\behaviors\BlameableBehavior;
use drodata\behaviors\LookupBehavior;

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 * 
<?php foreach ($tableSchema->columns as $column): ?>
 * @property <?= "{$column->phpType} \${$column->name}\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
    public function init()
    {
        parent::init();
        // custom code follows
<?php if ($generator->hasItems): ?>
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'deleteItems']);
<?php endif; ?>
<?php if ($generator->isJunction): ?>
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'deleteJunctionModel']);
<?php endif; ?>
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * @inheritdoc
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>

    /**
     * key means scenario names
     */
    public function transactions()
    {
        return [
            'default' => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'lookup' => [
                'class' => LookupBehavior::className(),
                'labelMap' => [
                    'visible' => ['boolean', []],
                ],
            ],
<?php if (in_array('created_at', $tableSchema->columnNames)): ?>
            'timestamp' => [
                'class' => TimestampBehavior::className(),
<?php if (!in_array('updated_at', $tableSchema->columnNames)): ?>
                'updatedAtAttribute' => false,
<?php endif; ?>
            ],
<?php endif; ?>
<?php if (in_array('created_by', $tableSchema->columnNames)): ?>
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'humanReadAttribute' => 'display_name',
<?php if (!in_array('updated_by', $tableSchema->columnNames)): ?>
                'updatedByAttribute' => false,
<?php endif; ?>
            ],
<?php endif; ?>
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . ",\n        " ?>];
        /**
         * CODE TEMPLATE
         *
            ['passwordOld', 'inlineV'],
            [
                'billing_period', 'required', 
                'when' => function ($model, $attribute) {
                    return $model->payment_way != self::PAYMENT_WAY_SINGLE;
                },
                'on' => self::SCENARIO_ACCOUNTANT,
                'whenClient' => "function (attribute, value) {
                    return $('#company-payment_way input:checked').val() != '1';
                }",
            ],
        */
    }

    /**
     * CODE TEMPLATE inline validator
     *
    public function inlineV($attribute, $params, $validator)
    {
        if ($this->$attribute != 'a') {
            $this->addError($attribute, 'error message');
            return false;
        }
        return true;
    }
    */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }

    /**
     * 反回操作链接
     *
     * @param string $action action name
     * @param array $configs 参考 Html::actionLink()
     * @return mixed the link html content
     */
    public function actionLink($action, $configs = [])
    {
        list($route, $options) = $this->getActionOptions($action);

        return Html::actionLink($route, ArrayHelper::merge($options, $configs));
    }

    /**
     * 返回 actionLink() 核心属性
     *
     * @param string $action 对应 actionLink() 中 $action 值
     * @see actionLink()
     *
     * @return array 两个个元素依次表示：action route, action link options
     *
     */
    public function getActionOptions($action)
    {
        // reset control options
        $visible = true;
        $hint = null;
        $confirm = null;
        $route = ["/<?= Inflector::camel2id($generator->modelClass) ?>/$action", <?= $generator->generatePrimayKeyParamString($tableName) ?>];

        switch ($action) {
            case 'view':
                $options = [
                    'title' => '查看',
                    'icon' => 'eye',
                    // disable modal view feature by commenting the following line.
                    'class' => 'modal-view',
                ];
                break;
            case 'update':
                $options = [
                    'title' => '修改',
                    'icon' => 'pencil',
                ];
                //$visible = Yii::$app->user->can('x');
                if (0) {
                    $hint = 'xx';
                }
                break;

            case 'delete':
                $options = [
                    'title' => '删除',
                    'icon' => 'trash',
                    'color' => 'danger',
                    'data' => [
                        'method' => 'post',
                        'confirm' => '确定要执行删除操作吗？',
                    ],
                ];
                //$visible = Yii::$app->user->can('x');
                if (0) {
                    $hint = 'xx';
                }
                break;

            default:
                break;
        }

        // combine control options with common options
        return [$route, ArrayHelper::merge($options, [
            'type' => 'icon',
            'visible' => $visible,
            'disabled' => $hint,
            'disabledHint' => $hint,
        ])];
    }

    // ==== getters start ====

<?php foreach ($relations as $name => $relation): ?>
    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>

    /**
     * CODE TEMPLATE
     *
     * @return User|null
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
     */

    /**
     * 通用的、无需 sort 和 pagination 的 data provider
     * @param string $key 
     */
    public function getDataProvider($key)
    {
        switch ($key) {
<?php if ($generator->hasItems): ?>
            case 'items':
                $query = $this->getItems();
                break;
<?php endif; ?>
            default:
                $query = null;
                break;
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);
    }

<?php if ($generator->hasItems): ?>
    /**
     * Return quantity sum of items
     *
     * @param string|false $format 'integer', 'decimal' etc, raw number is returned when $format is false
     * @return number|string string is returned when $format is true
     */
    public function getQuantity($format = false)
    {
        return $this->getItemsSum('quantity', $format);
    }
    /**
     * Return charge sum of items
     *
     * @param string|false $format 'integer', 'decimal' etc, raw number is returned when $format is false
     * @return number|string string is returned when $format is true
     */
    public function getCharge($format = false)
    {
        return $this->getItemsSum('charge', $format);
    }

    /**
     * Caculate items sum.
     *
     * @param string $key 'quantity' or 'charge'
     * @param string|false $format 'integer', 'decimal' etc, raw number is returned when $format is false
     * @return number|string string is returned when $format is true
     */
    protected function getItemsSum($key, $format)
    {
        if (empty($this->getDataProvider('items')->models)) {
            return 0;
        }

        $sum = 0;
        foreach ($this->getDataProvider('items')->models as $item) {
            if ($key == 'quantity') {
                $sum += $item->quantity;
            } elseif ($key == 'charge') {
                $sum += $item->price * $item->quantity;
            }
        }

        if (!$format) {
            return $sum;
        }

        switch ($format) {
            case 'integer':
                return Yii::$app->formatter->asInteger($sum);
                break;
            case 'decimal':
                return Yii::$app->formatter->asDecimal($sum);
                break;
        }
    }
<?php endif; ?>

    // ==== getters end ====

    /**
     * CODE TEMPLATE
     *
    public function sign()
    {
        $this->status = 3;
        if (!$this->save()) {
            throw new Exception('Failed to save.');
        }
    }
     */

<?php if ($generator->ajaxSubmit): ?>
    /**
     *
     * AJAX 提交表单逻辑代码
     *
     */
    public static function ajaxSubmit($post)
    {
        $d['status'] = true;

        if (empty($post['Spu']['id'])) {
            $model = new Spu();
        } else {
            $model = Spu::findOne($post['Spu']['id']);
        }
        $model->load($post);

        // items
        $items = [];
        foreach ($post['PurchaseItem'] as $index => $item) {
            $items[$index] = new PurchaseItem();
        }
        PurchaseItem::loadMultiple($items, $post);
        foreach ($post['PurchaseItem'] as $index => $item) {
            $d['status'] = $items[$index]->validate() && $d['status'];
            if (!$items[$index]->validate()) {
                $key = "purchaseitem-$index";
                $d['errors'][$key] = $items[$index]->getErrors();
            }
        }

        // all data is safe, start to submit 
        if ($d['status']) {
            // 根据需要调整如 status 列值
            $model->on(self::EVENT_AFTER_INSERT, [$model, 'insertItems'], $items);

            $model->on(self::EVENT_BEFORE_UPDATE, [$model, 'deleteItems']);
            $model->on(self::EVENT_AFTER_UPDATE, [$model, 'insertItems'], $items);

            if (!$model->save()) {
                throw new Exception($model->stringifyErrors());
            }
            
            $d['message'] = Html::tag('span', Html::icon('check') . '已保存', [
                'class' => 'text-success',
            ]);
            $d['redirectUrl'] = Url::to(['/purchase/index']);
        }

        return $d;
    }
<?php endif; ?>

    // ==== event-handlers begin ====

<?php if ($generator->hasItems): ?>
    /**
     * 保存子条目。由 self::EVENT_AFTER_INSERT 触发
     */
    public function insertItems($event)
    {
        $items = $event->data;

        foreach ($items as $item) {
            if (!$item->save()) {
                throw new Exception($item->stringifyErrors());
            }
        }

    }

    /**
     * 删除子条目
     *
     * 由 self::EVENT_BEFORE_DELETE 触发
     */
    public function deleteItems($event)
    {
        if (empty($this->items)) {
            return;
        }
        foreach ($this->items as $item) {
            if (!$item->delete()) {
                throw new Exception($item->stringifyErrors());
            }
        }
    }
<?php endif; ?>
<?php if ($generator->isJunction): ?>
    /**
     * Delete the junction record before deleting
     *
     * Triggered by self::EVENT_AFTER_DELETE
     */
    public function deleteJunctionModel($event)
    {
        /** NOTE: Uncomment and implement
         *
        if (!$this->analysis->delete()) {
            throw new \yii\db\Exception('Failed to delete.');
        }
         */
    }
<?php endif; ?>
    // ==== event-handlers end ====
}
