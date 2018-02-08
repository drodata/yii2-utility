<?php

namespace drodata\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use drodata\helpers\Html;
use drodata\helpers\Utility;
use drodata\behaviors\TimestampBehavior;
use drodata\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%taxonomy}}".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $slug
 * @property integer $parent_id
 * @property integer $visible
 *
 * @property Taxonomy $parent
 * @property Taxonomy[] $taxonomies
 */
class Taxonomy extends \drodata\db\ActiveRecord
{
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
        return '{{%taxonomy}}';
    }


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
        return [
            [['visible'], 'default', 'value' => 1],

            [['type', 'name'], 'required'],
            [
                ['name'], 'unique', 
                'targetAttribute' => ['name', 'type'],
                'message' => '{value} 已经被占用，请更换一个名字',
            ],
            [
                ['parent_id'], 'validateParentId',
                'when' => function ($model, $attribute) {
                    return !$model->isNewRecord;
                },
            ],
            [['parent_id', 'visible'], 'integer'],
            [['type', 'name', 'slug'], 'string', 'max' => 50],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Taxonomy::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    public function validateParentId($attribute, $params, $validator)
    {
        if ($this->$attribute == $this->id) {
            $this->addError($attribute, '上级目录不能是自己');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类别',
            'name' => '名称',
            'slug' => 'Slug',
            'parent_id' => '上级目录',
            'visible' => '是否可见',
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
        $route = '/taxonomy/' . $action;
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
                        'disabled' => false,
                        'disabledHint' => '',
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
                            'confirm' => $this->getConfirmText(),
                        ],
                        'visible' => true, // Yii::$app->user->can(''),
                        'disabled' => false,
                        'disabledHint' => '',
                    ]
                );
                break;
        }
    }

    /**
     * 获取 POST 操作前的 confirm 文本内容
     *
     * 模型中有很多类似删除这样的操作：没有视图文件，直接通过控制器完成操作，
     * 操作完成后页面跳转至 referrer 而非首页。这类操作前都需要让客户再次确认。
     *
     * @param string $action 对应 actionLink() 中 $action 值
     */
    public function getConfirmText($action = 'delete')
    {
        switch ($action) {
            case 'delete':
                return "请再次确认删除操作。";
                break;
        }
    }

    // ==== getters start ====

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Taxonomy::className(), ['id' => 'parent_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaxonomies()
    {
        return $this->hasMany(Taxonomy::className(), ['parent_id' => 'id']);
    }

    public static function ajaxSubmit($post)
    {
        $d['status'] = true;

        if (empty($post['Taxonomy']['id'])) {
            $model = new Taxonomy();
        } else {
            $model = Taxonomy::findOne($post['Taxonomy']['id']);
        }
        $model->load($post);

        $d['status'] = $model->validate() && $d['status'];
        if (!$model->validate()) {
            $d['errors']['taxonomy'] = $model->getErrors();
        }

        // all data is safe, start to submit 
        if ($d['status']) {
            if (!$model->save()) {
                throw new \yii\db\Exception($model->stringifyErrors());
            }
            $d = ArrayHelper::merge($d, [
                'id' => $model->id,
                'name' => $model->name,
                'message' => Html::tag('span', Html::icon('check') . '已保存', ['class' => 'text-success']),
                'option' => Html::tag('option', $model->name, [
                    'value' => $model->id,
                    'selected' => true,
                ]),
            ]);
        }

        return $d;
    }
}
