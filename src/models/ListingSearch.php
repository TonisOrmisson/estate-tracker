<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Listing;

/**
 * ListingSearch represents the model behind the search form about `app\models\Listing`.
 */
class ListingSearch extends Listing
{
    /**
     * @var string $name
     */
    public $name;

    /*
     * @var string $title
     */
    public $title;

    /*
     * @var integer $rating
     */
    public $rating;

    /** @var integer */
    public $itemType;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['listing_id', 'parse_id', 'item_id','change','is_success','rating'], 'integer'],
            [['time_created','name','title', 'itemType'], 'safe'],
            [['price'], 'number'],
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
        $query = Listing::find();
        $query->joinWith(['item']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                    ],
                'sort' => [
                    'defaultOrder' => [
                        'listing_id' => SORT_DESC,
                    ]
                ],
            ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'listing_id' => $this->listing_id,
            'parse_id' => $this->parse_id,
            'item_id' => $this->item_id,
            'time_created' => $this->time_created,
            'change' => $this->change,
            'is_success' => $this->is_success,
            'price' => $this->price,
            'item.rating' => $this->rating,
            'item.item_type_id' => $this->itemType,
        ]);

        $query->andFilterWhere(['like', 'item.name', $this->name]);
        $query->andFilterWhere(['like', 'item.title', $this->title]);

        return $dataProvider;
    }
}
