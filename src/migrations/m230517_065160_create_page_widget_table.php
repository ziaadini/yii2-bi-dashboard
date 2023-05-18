<?php


use yii\db\Migration;

/**
 * Handles the creation of table `{{%page_widget}}`.
 */
class m230517_065160_create_page_widget_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page_widget}}', [
            'id' => $this->primaryKey()->unsigned(),
            'page_id' => $this->integer()->unsigned()->notNull(),
            'widget_id' => $this->integer()->unsigned()->notNull(),
            'shape_id' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'deleted_at' => $this->integer()->unsigned(),
            'updated_by' => $this->integer()->unsigned(),
            'created_by' => $this->integer()->unsigned(),
        ]);

        $this->createIndex('page_widget_ibfk_1', '{{%page_widget}}', 'page_id');
        $this->createIndex('page_widget_ibfk_2', '{{%page_widget}}', 'widget_id');
        $this->addForeignKey(
            'page_widget_ibfk_1',
            '{{%page_widget}}',
            ['page_id'],
            '{{%page}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'wpage_widget_ibfk_2',
            '{{%page_widget}}',
            ['widget_id'],
            '{{%widget}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page_widget}}');
    }
}
