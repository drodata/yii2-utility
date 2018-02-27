<?php

namespace drodata\models;

/**
 * This is the ActiveQuery class for [[Option]].
 *
 * @see Option
 */
class OptionQuery extends \yii\db\ActiveQuery
{
    /*
     *
    public function active()
    {
        return $this->andWhere(['id' => 1]);
    }
    */

    /**
     * @inheritdoc
     * @return Option[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Option|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
