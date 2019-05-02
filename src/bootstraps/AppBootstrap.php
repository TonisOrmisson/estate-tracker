<?php
namespace app\bootstraps;

use yii\base\BootstrapInterface;
use yii;

class AppBootstrap implements BootstrapInterface{


    public function bootstrap($app){
        $this->setTimezone();
    }

    private function setTimezone()
    {
        if(isset(Yii::$app->params['timeZone'])){
            Yii::$app->setTimeZone(Yii::$app->params['timeZone']);
        }
    }

}