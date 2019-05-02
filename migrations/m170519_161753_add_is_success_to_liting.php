<?php

use yii\db\Migration;

class m170519_161753_add_is_success_to_liting extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%listing}}','is_success',$this->boolean()->after('m2'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%listing}}', 'is_success');
    }
}
