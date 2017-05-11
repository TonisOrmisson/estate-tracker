<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Parse;

/**
 * ParseSearch represents the model behind the search form about `app\models\Parse`.
 */
class ParseSearch extends Parse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parse_id', 'provider_id', 'items_parsed'], 'integer'],
            [['time_start', 'time_end'], 'safe'],
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
        $query = Parse::find();

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
            'parse_id' => $this->parse_id,
            'provider_id' => $this->provider_id,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'items_parsed' => $this->items_parsed,
        ]);

        return $dataProvider;
    }
}
