<?php

namespace drodata\utility\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%lookup}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $code
 * @property string $type
 * @property integer $position
 */
class Lookup extends \yii\db\ActiveRecord
{
	private static $_items=array();
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lookup}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'type', 'position'], 'required'],
            [['code', 'position'], 'integer'],
            [['name', 'type'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'type' => 'Type',
            'position' => 'Position',
        ];
    }
	public static function items($type, $key='code')
	{
		return ArrayHelper::map(
			self::find()->where([
				'type' => $type,
			])->orderBy('position')->asArray()->all(),
			$key,
			'name'
		);
	}

	public static function item($type,$code)
	{
		return self::findOne([
			'type' => $type,
			'code' => $code,
		])->name;
	}
}
