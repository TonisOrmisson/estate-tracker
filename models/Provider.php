<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "provider".
 *
 * @property integer $provider_id
 * @property string $name
 * @property string $url
 * @property integer $active
 * @property string $locator_options
 * @property string $comment
 *
 * @property Item[] $items
 * @property Parse[] $parses
 * @property Item $firstUpdatedItem
 */
class Provider extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'locator_options' ], 'required'],
            [['active'], 'integer'],
            [['comment'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['url'], 'string', 'max' => 512],
            [['locator_options'], 'string', 'max' => 1024*2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'provider_id' => Yii::t('app', 'Provider ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Base Url including the {itemKey} tag'),
            'active' => Yii::t('app', 'Active'),
            'locator_options' => Yii::t('app', 'The locator to identify the main content in item listing'),
            'comment' => Yii::t('app', 'comments'),
        ];
    }

    /**
     * @param integer $count
     * @return Item[]
     */
    public function getParsableItems($count=1){
        if($this->firstUpdatedItem){
            return [$this->firstUpdatedItem];
        }
        return [];
    }

    /**
     * Get the item from that provider that was updated first (most time passed)
     * @return Item
     */
    public function getFirstUpdatedItem(){
        $subQuery = Listing::find()
            ->select('time_created')
            ->andWhere('item_id =`item`.`item_id`')
            ->orderBy('time_created DESC')
            ->limit(1)
            ->createCommand()->rawSql;

        $query = Item::find()
            ->select(['item.*','('.$subQuery.') as time_last_listing'])
            ->andWhere(['provider_id'=>$this->primaryKey])
            ->andWhere(['active'=>1])
            ->orderBy('time_last_listing')
            ->limit(1)
        ;
        //echo $query->createCommand()->rawSql;
        /** @var Item $model */
        $model=$query->one();
        return $model;
    }


    /* @inheritdoc */
    public function getOptionVars()
    {
        return [
            'titleClass'=>[
                'label' => Yii::t('app','Item title class name'),
            ],
            'contentClass'=>[
                'label' => Yii::t('app','Item main content class name'),
            ],
            'priceClass'=>[
                'label' => Yii::t('app','Price element class name'),
            ],
            'm2Id'=>[
                'label' => Yii::t('app','Id containing m2 as value'),
            ],
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['provider_id' => 'provider_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParses()
    {
        return $this->hasMany(Parse::className(), ['provider_id' => 'provider_id']);
    }
}
