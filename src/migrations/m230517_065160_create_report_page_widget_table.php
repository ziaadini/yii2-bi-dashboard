<?php


use yii\db\Migration;
use yii\db\Expression;
/**
 * Handles the creation of table `{{%page_widget}}`.
 */
class m230517_065160_create_report_page_widget_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%report_page_widget}}', [
            'id' => $this->primaryKey()->unsigned(),
            'page_id' => $this->integer()->unsigned()->notNull(),
            'widget_id' => $this->integer()->unsigned()->notNull(),
            'report_widget_field' => $this->string(64),
            'report_widget_field_format' => $this->tinyInteger(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->unsigned(),
            'created_by' => $this->integer()->unsigned(),
        ]);

        $this->createIndex('page_widget_ibfk_1', '{{%report_page_widget}}', 'page_id');
        $this->createIndex('page_widget_ibfk_2', '{{%report_page_widget}}', 'widget_id');
        $this->addForeignKey(
            'page_widget_ibfk_1',
            '{{%report_page_widget}}',
            ['page_id'],
            '{{%report_page}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'page_widget_ibfk_2',
            '{{%report_page_widget}}',
            ['widget_id'],
            '{{%report_widget}}',
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
        $this->dropTable('{{%report_page_widget}}');
    }
}
