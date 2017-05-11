<?php

namespace app\models;

use andmemasin\helpers\DateHelper;
use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "parse".
 *
 * @property integer $parse_id
 * @property integer $provider_id
 * @property string $time_start
 * @property string $time_end
 * @property integer $items_parsed
 *
 * @property Listing[] $listings
 * @property Provider $provider
 */
class Parse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider_id', 'time_start'], 'required'],
            [['provider_id', 'items_parsed'], 'integer'],
            [['time_start', 'time_end'], 'safe'],
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provider::className(), 'targetAttribute' => ['provider_id' => 'provider_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parse_id' => Yii::t('app', 'Parse ID'),
            'provider_id' => Yii::t('app', 'Provider ID'),
            'time_start' => Yii::t('app', 'Started parsing'),
            'time_end' => Yii::t('app', 'Finished parsing'),
            'items_parsed' => Yii::t('app', 'Items Parsed'),
        ];
    }

    /**
     * @param Item $item
     */
    public function parse($item)
    {
        $html = Response::getResponse($item->url);
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML('<?xml encoding="UTF-8">' .$html);
        $finder = new \DomXPath($doc);
        $locatorData = Json::decode($this->provider->content_locator);
        $nodes = $finder->query("//*[contains(@class, '".$locatorData['class']."')]");
        $content = $nodes->item(0)->textContent;

        $listing = new Listing();
        $listing->item_id = $item->primaryKey;
        $listing->time_created = DateHelper::getDatetime6();
        $listing->content = $content;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::className(), ['parse_id' => 'parse_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(Provider::className(), ['provider_id' => 'provider_id']);
    }
}
