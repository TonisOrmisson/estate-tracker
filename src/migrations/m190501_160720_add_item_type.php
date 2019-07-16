<?php

use yii\db\Migration;

/**
 * Class m190501_160720_add_item_type
 */
class m190501_160720_add_item_type extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('item_type', [
            'item_type_id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'comment' => $this->text()->null()->comment('comments'),
        ], $tableOptions);
        $this->createIndex('item_type_name', 'item_type', ['name']);

        $this->insert('item_type', [
           'item_type_id' => 1,
           'name' => 'Default type',
        ]);

        $this->addColumn('item', 'item_type_id', $this->integer()->notNull());
        $this->update('item', ['item_type_id' => 1]);

        $this->addForeignKey('fk_item_item_type_id', 'item', 'item_type_id', 'item_type', 'item_type_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_item_item_type_id', 'item');
        $this->dropColumn('item', 'item_type_id');
        $this->dropTable('{{%item_type}}');
    }

}
