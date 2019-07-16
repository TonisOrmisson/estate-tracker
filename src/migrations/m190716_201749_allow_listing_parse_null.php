<?php

use yii\db\Migration;

/**
 * Class m190716_201749_allow_item_parse_null
 */
class m190716_201749_allow_listing_parse_null extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('listing', 'parse_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('listing', 'parse_id', $this->integer()->notNull());
    }
}
