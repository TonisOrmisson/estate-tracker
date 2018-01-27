<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ItemSearch represents the model behind the search form about `app\models\Item`.
 */
class ItemSearch extends Item
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'provider_id','active'], 'integer'],
            [['key', 'time_created'], 'safe'],
            [[ 'content'], 'string'],
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
        $query = Item::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'item_id' => $this->item_id,
            'provider_id' => $this->provider_id,
            'time_created' => $this->time_created,
            'active' => $this->active,
            'content' => $this->content,
        ]);
        $query->orderBy(['item_id'=>SORT_DESC]);

        $query->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }
}
