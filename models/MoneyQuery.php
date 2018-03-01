<?php

namespace drodata\models;

/**
 * This is the ActiveQuery class for [[Money]].
 *
 * @see Money
 */
class MoneyQuery extends \yii\db\ActiveQuery
{
    /*
     * post
     */
    public function post()
    {
        return $this->andWhere(['{{%money}}.is_post' => 1]);
    }

    /*
     * pre
     */
    public function pre()
    {
        return $this->andWhere(['{{%money}}.is_post' => 0]);
    }

    /*
     * type
     */
    public function ofType($type)
    {
        return $this->andWhere(['{{%money}}.type' => $type]);
    }

    /**
     * @inheritdoc
     * @return Money[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Money|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
