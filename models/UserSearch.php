<?php

namespace drodata\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use drodata\validators\DateRangeValidator;
use drodata\models\User;

/**
 * UserSearch represents the model behind the search form about `drodata\models\User`.
 */
class UserSearch extends User
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
            [['id', 'username', 'mobile_phone', 'auth_key', 'password_hash', 'password_reset_token', 'access_token', 'email'], 'safe'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], DateRangeValidator::classname()],
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
        $query = User::find();
        /*
        $query = User::find()->joinWith(['company']);
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
                'id' => SORT_DESC,
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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['between', 'created_at', empty($this->created_at) ? '' : strtotime(explode('-', $this->created_at)[0] . ' 00:00:00'), empty($this->created_at) ? '' : strtotime(explode('-', $this->created_at)[1] . ' 23:59:59')])
            ->andFilterWhere(['between', 'updated_at', empty($this->updated_at) ? '' : strtotime(explode('-', $this->updated_at)[0] . ' 00:00:00'), empty($this->updated_at) ? '' : strtotime(explode('-', $this->updated_at)[1] . ' 23:59:59')]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'mobile_phone', $this->mobile_phone])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'email', $this->email]);
            //->andFilterWhere(['LIKE', 'user_group.name', $this->getAttribute('group.name')])

        return $dataProvider;
    }

}
