<?php

use yii\db\Migration;

class m170510_130144_initial extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%provider}}', [
            'provider_id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'url' => $this->string(512)->notNull()->comment('Base Url including the {itemKey} tag'),
            'active' => $this->boolean()->notNull()->defaultValue(1),
            'content_locator' => $this->string(255)->notNull()->comment('The locator to identify the main content in item listing'),
            'comment' => $this->text()->notNull()->comment('comments'),
        ], $tableOptions);

        $this->createTable('{{%parse}}', [
            'parse_id' => $this->primaryKey(),
            'provider_id' => $this->integer()->notNull(),
            'time_start' => $this->dateTime(6)->notNull()->comment("Started parsing"),
            'time_end' => $this->dateTime(6)->null()->comment("Finished parsing"),
            'items_parsed' => $this->integer()->null(),
        ], $tableOptions);

        $this->createTable('{{%item}}', [
            'item_id' => $this->primaryKey(),
            'provider_id' => $this->integer()->notNull(),
            'key' => $this->string(255)->notNull()->comment('The item key/id in the provider to identify the item'),
            'time_created' => $this->dateTime(6)->notNull()->comment("Time created"),
        ], $tableOptions);

        $this->createTable('{{%listing}}', [
            'listing_id' => $this->primaryKey(),
            'parse_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
            'time_created' => $this->dateTime(6)->notNull()->comment("Time created"),
            'price' => $this->double()->comment("Item Price"),
            'content' => $this->double()->comment("Item listing content text"),
        ], $tableOptions);
        $this->createTable('{{%user_has_item}}', [
            'user_has_item_id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
            'user_created' => $this->integer()->notNull(),
            'time_created' => $this->dateTime(6)->notNull()->comment("Time created"),
            'active' => $this->boolean()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->addForeignKey('fk_parse_provider_id','{{%parse}}','provider_id','{{%provider}}','provider_id');
        $this->addForeignKey('fk_item_provider_id','{{%item}}','provider_id','{{%provider}}','provider_id');
        $this->addForeignKey('fk_listing_parse_id','{{%listing}}','parse_id','{{%parse}}','parse_id');
        $this->addForeignKey('fk_listing_item_id','{{%listing}}','item_id','{{%item}}','item_id');
        $this->addForeignKey('fk_user_has_item_item_id','{{%user_has_item}}','item_id','{{%item}}','item_id');
        $this->addForeignKey('fk_user_has_item_user_id','{{%user_has_item}}','user_id','{{%user}}','id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_parse_provider_id','{{%parse}}');
        $this->dropForeignKey('fk_item_provider_id','{{%item}}');
        $this->dropForeignKey('fk_listing_parse_id','{{%listing}}');
        $this->dropForeignKey('fk_listing_item_id','{{%listing}}');
        $this->dropForeignKey('fk_user_has_item_item_id','{{%user_has_item}}');
        $this->dropForeignKey('fk_user_has_item_user_id','{{%user_has_item}}');

        $this->dropTable('{{%user_has_item}}');
        $this->dropTable('{{%listing}}');
        $this->dropTable('{{%item}}');
        $this->dropTable('{{%parse}}');
        $this->dropTable('{{%provider}}');
    }
}
