<?php

use yii\db\Migration;

/**
 * Class m180127_190113_add_name_and_rating
 */
class m180127_190113_add_name_and_rating extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('item','name',$this->string(255)->null()->after('key'));
        $this->addColumn('item','rating',$this->integer()->defaultValue(0)->notNull()->after('name'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('item','name');
        $this->dropColumn('item','rating');
    }

}
