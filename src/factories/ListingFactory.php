<?php


namespace app\factories;


use andmemasin\helpers\DateHelper;
use app\models\Item;
use app\models\Listing;
use Yii;

class ListingFactory
{
    /**
     * @param Item $item
     * @return Listing|void
     */
    public function makeForItem($item){
        Yii::info("Making new listing for item $item->primaryKey", __METHOD__);
        $listing = new Listing();
        $listing->item_id = $item->primaryKey;
        $listing->time_created = (new DateHelper)->getDatetime6();
        $listing->is_success = 0;
        $listing->is_last = 1;

        // disable if not working
        if(!$item->isWorking){
            Yii::info("Item $item->primaryKey not working any more, disabling", __METHOD__);
            $item->active = 0;
            $item->time_changed = (new DateHelper)->getDatetime6();
            $listing->save();
            $item->save();
            return;
        }
        $listing->save();

        Listing::updateAll(['is_last' => 0], [
            'and',
            ['item_id' => $item->primaryKey],
            ['!=', 'listing_id', $listing->primaryKey]
        ]);
        return $listing;
    }

}
