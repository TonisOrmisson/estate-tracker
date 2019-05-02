<?php

use yii\db\Migration;

class m170511_090807_add_m2 extends Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%item}}','m2',$this->double(2)->after('key'));
        $this->addColumn('{{%listing}}','m2',$this->double(2)->after('price'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%item}}','m2');
        $this->dropColumn('{{%listing}}','m2');
    }
}
