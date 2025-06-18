<?php

use yii\db\Migration;

class m250616_154416_create_table_track extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE track_status AS ENUM ('new', 'in_progress', 'completed', 'failed', 'canceled')");
        $this->createTable('{{%track}}', [
            'id' => $this->primaryKey(),
            'track_number' => $this->string(255)->notNull()->unique(),
            'status' => "track_status NOT NULL DEFAULT 'new'",
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->integer()->null()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250616_154416_create_table_track cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250616_154416_create_table_track cannot be reverted.\n";

        return false;
    }
    */
}
