<?php

namespace drodata\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use drodata\validators\DateRangeValidator;
use drodata\models\Rate;

/**
 * RateSearch represents the model behind the search form about `drodata\models\Rate`.
 */
class RateSearch extends Rate
{
    public function attributes()
    {
        return parent::attributes();

        // add related fields to searchable attributes
        // return array_merge(parent::attributes(), ['author.name']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], DateRangeValidator::classname()],
            [['currency'], 'safe'],
            [['value'], 'number'],
            // usefull when filtering on related columns
            //[['author.name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Rate::find();
        /*
        $query = Rate::find()->joinWith(['company']);
            ->where(['{{%company}}.category' => Company::CATEGORY_LOGISTICS]);
        if (Yii::$app->user->can('saler') && !Yii::$app->user->can('saleDirector')) {
            $query->andWhere(['{{%interaction}}.created_by' => Yii::$app->user->id]);
        }
        */

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                /*
                'office_phone',
                'company.name' => [
                    'asc'  => ['CONVERT({{%company}}.full_name USING gbk)' => SORT_ASC],
                    'desc' => ['CONVERT({{%company}}.full_name USING gbk)' => SORT_DESC],
                ],
                */
            ],
            // Warning: defaultOrder 内指定的列必须在上面的 attributes 内声明过，否则排序无效
            'defaultOrder' => [
                'date' => SORT_DESC,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'value' => $this->value,
        ]);

        $query->andFilterWhere(['between', 'date', empty($this->date) ? '' : strtotime(explode('-', $this->date)[0] . ' 00:00:00'), empty($this->date) ? '' : strtotime(explode('-', $this->date)[1] . ' 23:59:59')]);

        $query->andFilterWhere(['like', 'currency', $this->currency]);
            //->andFilterWhere(['LIKE', 'user_group.name', $this->getAttribute('group.name')])

        return $dataProvider;
    }

}
