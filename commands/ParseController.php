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
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        /** @var Provider[] $providers */
        $providers = Provider::find()->all();
        foreach ($providers as $provider){
            $this->stdout($provider->name." ...\n", Console::BOLD);
            $parse = new Parse(['provider_id'=>$provider->primaryKey]);
            $parse->time_start = DateHelper::getDatetime6();
            if(!$parse->save()){
                \Yii::error("Error saving parse",__METHOD__);
                var_dump($parse->errors);

            }

            $items = $provider->getParsableItems();
            $i=0;
            if($items){
                foreach ($items as $item){
                    $this->stdout($item->key." \n", Console::FG_BLUE);
                    $parse->parse($item);
                    $i++;
                }
            }
            $parse->time_end = DateHelper::getDatetime6();
            $parse->items_parsed = $i;
            $parse->save();


        }
    }
}
