<?php


use yii\db\Migration;


/**
 * Handles the creation of table `{{%widget}}`.
 */
class m230517_064501_report_result_widget_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%widget_result}}', [
            'id' => $this->primaryKey()->unsigned(),
            'add_on' => $this->json()->defaultValue(new Expression('(JSON_OBJECT())')),
            'widget_id' => $this->integer()->unsigned()->notNull(),
            'start_range' => $this->integer()->unsigned()->notNull(),
            'end_range' => $this->integer()->unsigned()->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'update_by' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->unsigned()->notNull(),
        ]);
        $this->createIndex('widget_result_ibfk_1', '{{%widget_result}}', ['widget_id']);
        $this->addForeignKey(
            'widget_result_ibfk_1',
            '{{%widget_result}}',
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
        $this->dropTable('{{%widget_result}}');
    }
}
