<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "listing".
 *
 * @property integer $listing_id
 * @property integer $parse_id
 * @property integer $item_id
 * @property string $time_created
 * @property double $price
 * @property double $content
 *
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
            [['parse_id', 'item_id'], 'integer'],
            [['time_created'], 'safe'],
            [['price', 'content'], 'number'],
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
            'content' => Yii::t('app', 'Item listing content text'),
        ];
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
