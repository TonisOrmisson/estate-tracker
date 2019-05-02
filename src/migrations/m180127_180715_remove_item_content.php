<?php

use yii\db\Migration;

/**
 * Class m180127_180715_remove_item_content
 */
class m180127_180715_remove_item_content extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn('listing','content');
        // add content to items
        $this->addColumn('item','content', $this->text()->comment("Item listing content text"));

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180127_180715_remove_item_content cannot be reverted.\n";
        return false;
    }
}
