<?php

use yii\db\Migration;

/**
 * Class m180127_181745_add_item_title
 */
class m180127_181745_add_item_title extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('item','title',$this->text()->null()->after('key'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('item','title');
    }
}
