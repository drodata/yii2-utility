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
    protected function getActionOptions($action)
    {
        // reset control options
        $visible = true;
        $hint = null;
        $confirm = null;
        $route = ["/<?= Inflector::camel2id($generator->modelClass) ?>/$action", <?= $generator->generatePrimayKeyParamString($tableName) ?>];

        switch ($action) {
            case 'update':
                $options = [
                    'title' => '修改',
                    'icon' => 'pencil',
                ];
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
     * CODE TEMPLATE
     *
     * 无需 sort 和 pagination 的 data provider
     *
    public function getItemsDataProvider()
    {
        return new ActiveDataProvider([
            'query' => static::find(),
            'pagination' => false,
            'sort' => false,
        ]);
    }
    */

    /**
     * CODE TEMPLATE
     *
     * 搭配 getItemsDataProvider() 使用，
     * 计算累计值，可用在 grid footer 内
    public function getItemsSum()
    {
        $amount = 0;

        if (empty($this->itemsDataProvider->models)) {
            return $amount;
        }
        foreach ($this->itemsDataProvider->models as $item) {
            $amount += $item->quantity;
        }

        return $amount;
        
    }
     */

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

    /**
     * CODE TEMPLATE
     *
     * AJAX 提交表单逻辑代码
     *
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
            $model->on(self::EVENT_AFTER_INSERT, [$model, 'insertItems'], ['items' => $items]);

            $model->on(self::EVENT_BEFORE_UPDATE, [$model, 'deleteItems']);
            $model->on(self::EVENT_AFTER_UPDATE, [$model, 'insertItems'], ['items' => $items]);

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
    */

    // ==== event-handlers begin ====

    /**
     * CODE TEMPLATE
     *
     * 保存附件。
     *
     * 可由 self::EVENT_AFTER_INSERT, self::EVENT_UPLOAD 等触发
     *
     * @param yii\web\UploadedFile $event->data 承兑图片
    public function insertImages($event)
    {
        $images = $event->data;

        Media::store([
            'files' => $images,
            'referenceId' => $this->id,
            'type' => Media::TYPE_IMAGE,
            'category' => Media::CATEGORY_ACCEPTANCE,
            'from2to' => Mapping::ACCEPTANCE2MEDIA,
        ]);
    }
     */

    /**
     * CODE TEMPLATE
     *
     * 删除文件
     *
     * 由 self::EVENT_BEFORE_DELETE 触发
    public function deleteImages($event)
    {
        if (empty($this->images)) {
            return;
        }
        foreach ($this->images as $image) {
            if (!$image->delete()) {
                throw new Exception('Failed to flush image.');
            }
        }
    }
     */
    // ==== event-handlers end ====
}
