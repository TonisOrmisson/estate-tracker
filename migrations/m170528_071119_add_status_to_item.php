<?php

use yii\db\Migration;

class m170528_071119_add_status_to_item extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%item}}','active',$this->boolean()->notNull()->defaultValue(1)->after('m2'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%item}}','active');
    }}
