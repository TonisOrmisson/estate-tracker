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
        Yii::info("Extracted prixe for $item->primaryKey: " . $price, __METHOD__);
        $m2Node = null;
        $m2 = 0;
        if (!empty($locatorData['m2Id'])) {
            $m2Node = $doc->getElementById($locatorData['m2Id']);
        }

        if (!empty($locatorData['m2Class'])) {
            $m2Node = $finder->query("//*[contains(@class, '".$locatorData['m2Class']."')]")->item(0);
        }

        if (!empty($m2Node)) {
            $m2 = trim($m2Node->textContent);
            $m2 = str_replace(" EUR/m²", "", $m2);
            $m2 = str_replace(" ", "", $m2);
            $m2 = str_replace(",", ".", $m2);
            $m2 = floatval($m2);
        }


        $listing->price = $price;
        $listing->m2 = 0;

        // get the title
        $title = $finder->query("//*[contains(@class, '".$locatorData['titleClass']."')]")->item(0)->textContent;



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
