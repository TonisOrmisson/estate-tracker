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
        $locatorData = Json::decode($this->provider->locator_options);

        $contentNodes = $finder->query("//*[contains(@class, '".$locatorData['contentClass']."')]");
        $contentNode = $contentNodes->item(0);
        $content = $contentNode->ownerDocument->saveHTML($contentNode);

        $priceNodes = $finder->query("//*[contains(@class, '".$locatorData['priceClass']."')]");
        $price = strtolower($priceNodes->item(0)->textContent);
        $patterns[] = '/\s+/';
        $patterns[0] = '/eur/';
        $price = intval(trim(preg_replace('/\s+/', '', $price)));

        $m2Node = $doc->getElementById($locatorData['m2Id']);
        $m2 = doubleval(trim($m2Node->getAttribute('value')));

        $listing = new Listing();
        $listing->parse_id = $this->primaryKey;
        $listing->item_id = $item->primaryKey;
        $listing->time_created = DateHelper::getDatetime6();
        $listing->content = $content;
        $listing->price = $price;
        $listing->m2 = $m2;

        if(!$listing->save()){
            Yii::error("Error saving listing",__METHOD__);
            var_dump($listing->errors);
        }
        if($listing->m2 <> $item->m2){
            $item->m2= $listing->m2;
            $item->save();

        }

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