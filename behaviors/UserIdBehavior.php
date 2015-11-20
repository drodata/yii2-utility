<?php
namespace drodata\utility\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\base\InvalidCallException;
use yii\db\BaseActiveRecord;

/**
 * Inspired from TimestampBehavior, autofill `c_id` atrribute.
 */
class UserIdBehavior extends AttributeBehavior
{
	public $userIdAttribute = 'c_id';
	public $ownIdAttribute = 'own_id';
	public $value;
	
	public function init()
	{
		parent::init();
		if (empty($this->attributes)) {
			$this->attributes = [
				BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->userIdAttribute, $this->ownIdAttribute],
			];
		}
	}
}
