<?php

use yii\db\Migration;

class m170511_134208_add_item_change extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%item}}','time_changed',$this->dateTime(6)->null()->after('m2'));
        $this->addColumn('{{%listing}}','change',$this->boolean()->defaultValue(false)->after('m2'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%item}}','time_changed');
        $this->dropColumn('{{%listing}}','change');
    }
}
