<?php


namespace app\commands;


use app\models\Item;
use yii\console\Controller;
use yii\helpers\Console;

class ItemController extends Controller
{
    public function actionActivateAll() {
        $this->stdout("Activating all items" . PHP_EOL, Console::BOLD, Console::FG_GREEN);
        $result = Item::updateAll(['active' => 1]);
        $this->stdout("done $result records" . PHP_EOL, Console::BOLD, Console::FG_GREEN);
    }

}