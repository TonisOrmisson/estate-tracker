<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserHasItem;

/**
 * UserHasItemSearch represents the model behind the search form about `app\models\UserHasItem`.
 */
class UserHasItemSearch extends UserHasItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_has_item_id', 'user_id', 'item_id', 'user_created', 'active'], 'integer'],
            [['time_created'], 'safe'],
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
        $query = UserHasItem::find();

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
            'user_has_item_id' => $this->user_has_item_id,
            'user_id' => $this->user_id,
            'item_id' => $this->item_id,
            'user_created' => $this->user_created,
            'time_created' => $this->time_created,
            'active' => $this->active,
        ]);

        return $dataProvider;
    }
}
