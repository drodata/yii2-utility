<?php
/**
 * This is the template for generating the model class of a specified table.
 */

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
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use drodata\helpers\Html;
use drodata\behaviors\TimestampBehavior;
use drodata\behaviors\BlameableBehavior;

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
    // const STATUS_ = 1;
    // const SCENARIO_ = '';

    public function init()
    {
        parent::init();
        //$this->on(self::EVENT_AFTER_INSERT, [$this, 'handlerName']);
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
            /*
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'updatedByAttribute' => false,
                'humanReadAttribute' => 'display_name',
            ],
            */
        ];
    }

    /**
     * @inheritdoc
     *
    public function fields()
    {
        $fields = parent::fields();
        
        // 删除涉及敏感信息的字段
        //unset($fields['auth_key']);
        
        // 增加自定义字段
        return ArrayHelper::merge($fields, [
            'time' => function () {
                return $this->readableCreateTime;
            },
            'creator' => function () {
                return $this->readableCreator;
            },
        ]);
    }
    */

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . ",\n        " ?>];
        //['passwordOld', 'inlineV'],
        /*
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

    /* inline validator
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
     * Render a specified action link, which is usually used in 
     * GridView or ListView.
     *
     * @param string $action action name
     * @param string $type link type, 'icon' and 'button' are available,
     * the former is used in action column in grid view, while the latter
     * is use in list view.
     * @return mixed the link html content
     */
    public function actionLink($action, $type = 'icon')
    {
        $route = '/<?= $generator->generateTableName($tableName) ?>/' . $action;
        switch ($action) {
            case 'view':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    [
                        'type' => $type,
                        'title' => '详情',
                        'icon' => 'eye',
                        // comment the next line if you don't want to view model in modal.
                        'class' => 'modal-view',
                    ]
                );
                break;
            case 'update':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    [
                        'type' => $type,
                        'title' => '修改',
                        'icon' => 'pencil',
                        'visible' => true, // Yii::$app->user->can(''),
                        // 'disabled' => false,
                        // 'disabledHint' => '',
                    ]
                );
                break;
            case 'delete':
                return Html::actionLink(
                    [$route, 'id' => $this->id],
                    [
                        'type' => $type,
                        'title' => '删除',
                        'icon' => 'trash',
                        'color' => 'danger',
                        'data' => [
                            'method' => 'post',
                            'confirm' => '请再次确认删除操作。',
                        ],
                    ]
                );
                break;
        }
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

    /*
    public function getReadableStatus()
    {
        return Lookup::item('Status', $this->status);
    }
    public function getStatusLabel()
    {
        $map = [
            self::STATUS_ACTIVE => 'success',
            self::STATUS_ARCHIVED => 'default',
        ];
        $class = 'label label-' . $map[$this->status];
        return Html::tag('span', $this->readableStatus, ['class' => $class]);
    }

    /**
     * 无需 sort 和 pagination 的 data provider
     *
     */
    public function getItemsDataProvider()
    {
        return new ActiveDataProvider([
            'query' => static::find(),
            'pagination' => false,
            'sort' => false,
        ]);
    }
    */

<?php endforeach; ?>

    // ==== getters end ====

    /**
     * Transaction block template
     *
    public function create($data)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$this->save()) {
                throw new \yii\db\Exception('Failed to insert xxx.');
            }

            $transaction->commit();
            return true;
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    */

    // ==== event-handlers begin ====
    /**
     *
     * Triggerred by self::EVENT_AFTER_INSERT 
     *
    public function doSomething($event)
    {
        if (!$this->save()) {
            throw new \yii\db\Exception($this->stringifyErrors());
        }
    }
    */
    // ==== event-handlers end ====
}
