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
    // const STATUS_ = 1;
    // const SCENARIO_ = '';
    // 单独上传附件事件
    const EVENT_UPLOAD = 'upload';

    public function init()
    {
        parent::init();
        //$this->on(self::EVENT_BEFORE_DELETE, [$this, 'deleteItems']);
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
                    /*
                    'status' => ['status', [
                        1 => 'danger',
                    ]],
                    */
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
     * @param array $configs 动态配置数组。内容参见 Html::actionLink(). 例如 'view' 动作默认的 title 为 '详情',
     * 我想改成 "查看订单": `Html::actionLink('view', 'icon', ['title' => '查看订单'])
     * @return mixed the link html content
     */
    public function actionLink($action, $type = 'icon', $configs = [])
    {
        $route = '/<?= Inflector::camel2id($generator->modelClass) ?>/' . $action;
        list($visible, $hint, $confirm) = $this->getActionOptions($action);

        switch ($action) {
            case 'view':
                return Html::actionLink(
                    [$route, <?= $generator->generatePrimayKeyParamString($tableName) ?>],
                    ArrayHelper::merge([
                        'type' => $type,
                        'title' => '详情',
                        'icon' => 'eye',
                        // comment the next line if you don't want to view model in modal.
                        'class' => 'modal-view',
                    ], $configs)
                );
                break;
            case 'update':
                return Html::actionLink(
                    [$route, <?= $generator->generatePrimayKeyParamString($tableName) ?>],
                    ArrayHelper::merge([
                        'type' => $type,
                        'title' => '修改',
                        'icon' => 'pencil',
                        'visible' => $visible,
                        'disabled' => $hint,
                        'disabledHint' => $hint,
                    ], $configs)
                );
                break;
            case 'delete':
                return Html::actionLink(
                    [$route, <?= $generator->generatePrimayKeyParamString($tableName) ?>],
                    ArrayHelper::merge([
                        'type' => $type,
                        'title' => '删除',
                        'icon' => 'trash',
                        'color' => 'danger',
                        'data' => [
                            'method' => 'post',
                            'confirm' => $confirm,
                        ],
                        'visible' => $visible,
                        'disabled' => $hint,
                        'disabledHint' => $hint,
                    ], $configs)
                );
                break;
        }
    }

    /**
     * 返回 $action 常见的选项
     *
     * @param string $action 对应 actionLink() 中 $action 值
     * @see actionLink()
     *
     * @return array 三个元素依次表示：按钮可见性、禁用提示和确认提示
     *
     */
    public function getActionOptions($action)
    {
        $visible = true;
        $hint = null;
        $confirm = null;

        switch ($action) {
            case 'update':
                $visible = $visible && true;

                if (0) {
                    $hint = 'already paid';
                }
                break;
            case 'delete':
                $visible = $visible && true;

                if (false) {
                    $hint = 'already paid';
                }

                $confirm = '请再次确认';
                break;
        }

        return [$visible, $hint, $confirm];
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
     * @return User|null
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
     */

    /**
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
                throw new \yii\db\Exception($model->stringifyErrors());
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
                throw new \yii\db\Exception('Failed to flush image.');
            }
        }
    }
     */
    // ==== event-handlers end ====
}
