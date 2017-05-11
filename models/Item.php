<?php

namespace app\models;

use andmemasin\helpers\Replacer;
use Yii;

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
            'time_created' => Yii::t('app', 'Time created'),
        ];
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
