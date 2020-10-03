<?php

namespace app\commands;

use andmemasin\helpers\DateHelper;
use app\models\Item;
use app\models\Parse;
use app\models\Provider;
use yii\console\Controller;
use yii\helpers\Console;

class ParseController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param integer $limit
     */
    public function actionIndex($limit = 1)
    {
        /** @var Provider[] $providers */
        $providers = Provider::find()->all();
        foreach ($providers as $provider){
            $this->stdout($provider->name." ...\n", Console::BOLD);
            $parse = new Parse(['provider_id'=>$provider->primaryKey]);
            $parse->time_start = (new DateHelper)->getDatetime6();
            if(!$parse->save()){
                \Yii::error("Error saving parse",__METHOD__);
                var_dump($parse->errors);
                return;
            }

            $items = $provider->findParsableItems($limit);
            $i=0;
            if(!empty($items)){
                foreach ($items as $item){
                    $this->stdout($item->key." \n", Console::FG_BLUE);
                    $parse->parse($item);
                    $i++;
                }
            }
            $parse->time_end = (new DateHelper)->getDatetime6();
            $parse->items_parsed = $i;
            $parse->save();


        }
    }

    public function actionItem($id) {
        $item = Item::findOne($id);
        if (empty($item)) {
            $this->stdout("Item $id not found ...\n", Console::BOLD, Console::FG_RED);
            return;
        }
        $this->stdout("Parsing item $id ...\n");
        $parse = new Parse();
        $result = $parse->parse($item);
    }
}
