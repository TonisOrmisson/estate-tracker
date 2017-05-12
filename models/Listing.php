<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "listing".
 *
 * @property integer $listing_id
 * @property integer $parse_id
 * @property integer $change
 * @property integer $item_id
 * @property string $time_created
 * @property double $price
 * @property double $m2
 * @property string $content
 *
 * @property boolean $isChange Whether there is a change vs last Listing of this item
 * @property Item $item
 * @property Parse $parse
 */
class Listing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'listing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parse_id', 'item_id', 'time_created'], 'required'],
            [['parse_id', 'item_id','change'], 'integer'],
            [['time_created'], 'safe'],
            [['price','m2'], 'number'],
            [['content'], 'string','max'=>10*1024],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'item_id']],
            [['parse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Parse::className(), 'targetAttribute' => ['parse_id' => 'parse_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'listing_id' => Yii::t('app', 'Listing ID'),
            'parse_id' => Yii::t('app', 'Parse ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'time_created' => Yii::t('app', 'Time created'),
            'price' => Yii::t('app', 'Item Price'),
            'm2' => Yii::t('app', 'Item floor area in m2'),
            'content' => Yii::t('app', 'Item listing content text'),
            'change' => Yii::t('app', 'Was change detected?'),
        ];
    }

    /**
     * @return bool
     */
    public function getIsChange(){
        // not $this itself
        $lastListing = $this->item->getLastListing($this->primaryKey);
        if($lastListing){
            // initial
            return false;
        }
        if($lastListing->price <> $this->price){
            return true;
        }
        return false;

    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['item_id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParse()
    {
        return $this->hasOne(Parse::className(), ['parse_id' => 'parse_id']);
    }
}
