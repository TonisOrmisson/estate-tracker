<?php

namespace app\models;

use andmemasin\helpers\Replacer;
use function Sodium\library_version_minor;
use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "item".
 *
 * @property integer $item_id
 * @property integer $provider_id
 * @property string $key
 * @property string $time_created
 *
 * @property Provider $provider
 * @property Listing[] $listings
 * @property UserHasItem[] $userHasItems
 * @property string $url
 * @property array $itemStats
 * @property double $m2
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
            [['provider_id', 'key', 'time_created'], 'required'],
            [['provider_id'], 'integer'],
            [['time_created'], 'safe'],
            [['m2'], 'number'],
            [['key'], 'string', 'max' => 255],
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provider::className(), 'targetAttribute' => ['provider_id' => 'provider_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => Yii::t('app', 'Item ID'),
            'provider_id' => Yii::t('app', 'Provider ID'),
            'key' => Yii::t('app', 'The item key/id in the provider to identify the item'),
            'm2' => Yii::t('app', 'Item floor area in m2'),
            'time_created' => Yii::t('app', 'Time created'),
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
                new Expression('DATE_FORMAT(time_created,"%Y-%m-%d %H:%i:00") AS period'),
                'price'
            ]);
        return $query->createCommand()->queryAll();
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
                    $price = $row['price'] / $this->m2;
                }else{
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
        return $this->hasOne(Provider::className(), ['provider_id' => 'provider_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['item_id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserHasItems()
    {
        return $this->hasMany(UserHasItem::className(), ['item_id' => 'item_id']);
    }
}
