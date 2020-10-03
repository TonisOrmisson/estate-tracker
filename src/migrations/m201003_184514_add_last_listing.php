<?php

use yii\db\Migration;

/**
 * Class m201003_184514_add_last_listing
 */
class m201003_184514_add_last_listing extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('listing', 'is_last', $this->boolean()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('listing', 'is_last');
    }

}
