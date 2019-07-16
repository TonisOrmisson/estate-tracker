<?php

namespace app\models;

use andmemasin\helpers\DateHelper;
use app\factories\ListingFactory;
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
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provider::class, 'targetAttribute' => ['provider_id' => 'provider_id']],
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
        Yii::info("Parsing item $item->primaryKey", __METHOD__);

        $listing = (new ListingFactory())->makeForItem($item);
        if (empty($listing)) {
            Yii::info("Item $item->primaryKey disabled, skipping", __METHOD__);
            return null;
        }

        $html = Response::getResponse($item->url);
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML('<?xml encoding="UTF-8">' .$html);
        $finder = new \DomXPath($doc);
        $locatorData = Json::decode($item->provider->locator_options);

        try{
            $contentNodes = $finder->query("//*[contains(@class, '".$locatorData['contentClass']."')]");
            $contentNode = $contentNodes->item(0);
            $content = $contentNode->ownerDocument->saveHTML($contentNode);
            Yii::info("found content for $item->primaryKey", __METHOD__);

        }catch (\Exception $exception){
            $listing->save();
            Yii::error('Error parsing item ID: '.$item->primaryKey.' for '.$item->provider->name.':'.$item->key.' url:'.$item->url,__METHOD__);
            return;
        }


        $priceNodes = $finder->query("//*[contains(@class, '".$locatorData['priceClass']."')]");
        $price = strtolower($priceNodes->item(0)->textContent);
        Yii::info("Found price item for $item->primaryKey: " . serialize($price), __METHOD__);
        $patterns[] = '/\s+/';
        $patterns[0] = '/eur/';
        $price = intval(trim(preg_replace('/\s+/', '', $price)));
        Yii::info("Extracted price for $item->primaryKey: " . $price, __METHOD__);
        $m2Node = null;
        $m2 = 0;
        if (!empty($locatorData['m2Id'])) {
            Yii::info("looking for m2ID element for $item->primaryKey: ", __METHOD__);
            $m2Node = $doc->getElementById($locatorData['m2Id']);
        }

        if (!empty($locatorData['m2Class'])) {
            Yii::info("looking for m2CLASS element for $item->primaryKey: ", __METHOD__);
            $m2Node = $finder->query("//*[contains(@class, '".$locatorData['m2Class']."')]")->item(0);
        }

        if (!empty($m2Node)) {
            Yii::info("looking for m2node found for $item->primaryKey: ", __METHOD__);
            $m2 = trim($m2Node->textContent);
            Yii::info("initial m2node value for $item->primaryKey: " . serialize($m2), __METHOD__);
            $m2 = str_replace(' ', "", $m2);
            Yii::info("spaces removed m2node value for $item->primaryKey: " . $m2, __METHOD__);
            $m2 = str_replace(",", ".", $m2);
            Yii::info("commas fixed m2node value for $item->primaryKey: " . $m2, __METHOD__);
            preg_match('/([0-9]+\.?[0-9].)/', $m2, $matches);
            Yii::info("extracted m2 value for $item->primaryKey: " . serialize($matches), __METHOD__);
            $m2 = $matches[0];
            $m2 = floatval($m2);
            Yii::info("extracted m2 value for $item->primaryKey: " . $m2, __METHOD__);
        }


        $listing->price = $price;
        $listing->m2 = 0;

        // get the title

        $title = $finder->query("//*[contains(@class, '".$locatorData['titleClass']."')]")->item(0)->textContent;
        Yii::info("initial titleNode for $item->primaryKey: " . $title, __METHOD__);




        if($listing->isChange){
            $listing->change =  true;
            $item->time_changed = (new DateHelper)->getDatetime6();
        }
        $listing->is_success = 1;

        if(!$listing->save()){
            Yii::error("Error saving listing",__METHOD__);
            var_dump($listing->errors);
        }else{
            $item->save();
        }
        if($listing->m2 <> $item->m2 || $title <> $item->title ){
            $item->title = $title;
            $item->content = $content;
            $item->m2= $listing->m2;
            $item->save();

        }

    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListings()
    {
        return $this->hasMany(Listing::class, ['parse_id' => 'parse_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(Provider::class, ['provider_id' => 'provider_id']);
    }
}
