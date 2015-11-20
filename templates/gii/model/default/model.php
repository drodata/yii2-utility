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
use common\behaviors\UserIdBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n\t\t\t" . implode(",\n\t\t\t", $rules) . ",\n" ?>
			//['attribute', 'xx'],
		];
    }

	/*
	public function xx($attribute, $params)
	{
		if () {
            $this->addError($attribute, Yii::t('app.crud','xxx', [
			]));
        }
    }

	public function scenarios()
	{
		return [
			self::SCENARIO_LOGISTICS => ['contacter', 'cell_phone', 'office_phone', 'duty'],
			self::SCENARIO_LOGISTICS_BRANCH => ['company_id','contacter', 'cell_phone', 'office_phone', 'duty'],
		];
	}
	public function behaviors()
	{
	    return [
	        [
	            'class' => TimestampBehavior::className(),
	            'createdAtAttribute' => 'c_time',
	            'updatedAtAttribute' => false,
	            'value' => new Expression('NOW()'),
	        ],
	        [
				'class' => UserIdBehavior::className(),
				'userIdAttribute' => 'sender',
				'ownIdAttribute' => false,
				'value' => function ($event) {
					return Yii::$app->user->identity->id;
				},
			],
	    ];
	}

	public function getCompany()
	{
		return $this->hasOne(Company::className(), ['id' => 'company_id']);
		return $this->hasMany(Address::className(), ['address_id' => 'id']);
	}
	public function xxx()
	{
		Yii::$app->db->transaction(function() {
		});

		Yii::$app->session->setFlash('success', Yii::t('app.crud', 'Opetation saved.'));
		return true;
	}
	*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
		$labels = [
<?php foreach ($labels as $name => $label): ?>
			<?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
		];
		/*
		if ($this->scenario == self::SCENARIO_XXX)
		{
			$labels['company_id'] = 'New Company Name';
		}
		*/

		return $labels;
    }
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
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
}
