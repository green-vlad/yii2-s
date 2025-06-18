<?php

use yii\db\Migration;

class m250617_151327_alter_table_track extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('track', 'updated_at');
        $this->addColumn('track', 'updated_at', $this->timestamp()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250617_151327_alter_table_track cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250617_151327_alter_table_track cannot be reverted.\n";

        return false;
    }
    */
}
