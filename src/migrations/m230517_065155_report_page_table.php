<?php


use yii\db\Migration;
use yii\db\Expression;
/**
 * Class m230517_065155_page_table
 */
class m230517_065155_report_page_table extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%report_page}}', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string(128)->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
            'range_type' => $this->tinyInteger(),
            'add_on' => $this->json()->defaultValue(new Expression('(JSON_OBJECT())')),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->unsigned(),
            'created_by' => $this->integer()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%report_page}}');
    }
}
