<?php


use yii\db\Migration;

/**
 * Class m230517_065155_page_table
 */
class m230517_065155_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string(255)->notNull(),
            'route' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'deleted_at' => $this->integer()->unsigned(),
            'updated_by' => $this->integer()->unsigned(),
            'created_by' => $this->integer()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230517_065155_page_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230517_065155_page_table cannot be reverted.\n";

        return false;
    }
    */
}
