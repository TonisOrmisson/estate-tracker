<?php

namespace app\models;

use andmemasin\helpers\Replacer;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "item".
 *
 * @property integer $item_id
 * @property integer $provider_id
 * @property integer $item_type_id
 * @property string $key
 * @property string $time_created
 * @property string $time_changed
 *
 * @property Provider $provider
 * @property Listing[] $listings
 * @property Listing $lastListing
 * @property UserHasItem[] $userHasItems
 * @property string $url
 * @property array $itemStats
 * @property double $m2
 * @property integer $active
 * @property string $content
 * @property string $title
 * @property string $name
 * @property integer $rating
 * @property boolean $isWorking
 * @property ItemType $itemType
 */
class Item extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider_id', 'key', 'time_created','active','rating', 'item_type_id'], 'required'],
            [['provider_id','active', 'item_type_id'], 'integer'],
            [['time_created','time_changed'], 'safe'],
            [['m2'], 'number'],
            [['content'], 'string','max'=>10*1024],
            [['title'], 'string','max'=>1024],
            [['key','name'], 'string', 'max' => 255],
            [['rating'], 'number', 'max' => 10],
            ['key', 'unique', 'targetAttribute' => ['key', 'provider_id']],
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provider::class, 'targetAttribute' => ['provider_id' => 'provider_id']],
            [['item_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItemType::class, 'targetAttribute' => ['item_type_id' => 'item_type_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => Yii::t('app', 'ID'),
            'provider_id' => Yii::t('app', 'Provider'),
            'item_type_id' =>Yii::t('app', 'Item'),
            'key' => Yii::t('app', 'The item key/id in the provider to identify the item'),
            'm2' => Yii::t('app', 'Item floor area in m2'),
            'time_created' => Yii::t('app', 'Time created'),
            'time_changed' => Yii::t('app', 'Time of last change in source'),
            'content' => Yii::t('app', 'Item listing content text'),
            'title' => Yii::t('app', 'Title'),
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'key' => Yii::t('app', 'Look for an ID in the item URL'),
            'm2' => Yii::t('app', 'The m2 will be updated automatically while the data is parsed, but you can also set it manually'),
        ];
    }

    public function getItemStats(){

        $query = $this->getListings()
            ->select([
                new Expression('DATE_FORMAT(time_created,"%Y-%m-%d %H:00:00") AS period'),
                new Expression('MIN(price) as price'),
            ]);
        $query->groupBy('period');
        return $query->createCommand()->queryAll();
    }

    /**
     * @return bool
     */
    public function getIsWorking()
    {
        $checkCount = 100;
        $listings = $this->getLastListings($checkCount);
        if($listings){
            $countFailed = 0;
            foreach ($listings as $listing){
                if($listing->is_success <> 1){
                    $countFailed ++;
                }
            }
            return ($countFailed != $checkCount);
        }
        return true;
    }



    /**
     * @return array
     */
    public function getChartPriceData($perM2 = false){
        $data = $this->itemStats;
        $out = [];
        if(!empty($data)){
            foreach ($data as $row) {
                $date = new \DateTime($row['period']);
                if($perM2){

                    $price = $this->m2 > 0 ? $row['price'] / $this->m2 : 0;
                } else {
                    $price = $row['price'];
                }
                $out[] =[($date->format('U') * 1000),(integer) $price];
            }
        }
        return $out;
    }

    /**
     * @return string
     */
    public function getUrl(){
        $params = [
            'itemKey' =>$this->key
        ];
        return Replacer::replace($this->provider->url,$params);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(Provider::class, ['provider_id' => 'provider_id']);
    }

    public function getLastListing() : ActiveQuery
    {
        return $this->hasOne(Listing::class, ['item_id' => 'item_id'])->andWhere(['is_last' => 1]);
    }

    /**
     * @param int $notThisId An ID that we want to eliminate from search
     * @return Listing
     */
    public function getLastSuccessfulListing($notThisId = null)
    {
        $query = $this->getListings()
            ->orderBy(['listing_id'=>SORT_DESC])
            ->limit(1)
        ->andWhere(['is_success'=>1]);
        if($notThisId){
            $query->andWhere([new Expression('!='),'listing_id',$notThisId]);
        }

        /** @var Listing $model */
        $model = $query->one();
        return $model;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::class, ['item_id' => 'item_id']);
    }

    /**
     * @param $count
     * @return Listing[]
     */
    public function getLastListings($count){
        $query = Listing::find()
            ->andWhere(['item_id'=>$this->item_id])
            ->orderBy(['listing_id'=>SORT_DESC])
            ->limit($count);
        /** @var Listing[] $models */
        $models = $query->all();
        return $models;

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserHasItems()
    {
        return $this->hasMany(UserHasItem::class, ['item_id' => 'item_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemType()
    {
        return $this->hasOne(ItemType::class, ['item_type_id' => 'item_type_id']);
    }
}
