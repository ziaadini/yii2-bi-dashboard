<?php


use yii\db\Migration;


/**
 * Class m230517_063258_widget
 */
class m230517_063258_report_widget_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%widget}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(255)->Null(),
            'search_model' => $this->string(255)->notNull(),
            'method' => $this->string(255)->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'deleted_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_by' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%widget}}');
    }
    
}
