<?php

use yii\db\Migration;

class m250617_144632_insert_test_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', [
            'username' => 'user',
            'access_token' => 'user_access_token',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['username' => 'testuser']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250617_144632_insert_test_user cannot be reverted.\n";

        return false;
    }
    */
}
