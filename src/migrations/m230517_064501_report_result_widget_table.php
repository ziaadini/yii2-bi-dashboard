<?php


use yii\db\Migration;
use yii\db\Expression;

/**
 * Handles the creation of table `{{%widget}}`.
 */
class m230517_064501_report_result_widget_table extends Migration
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
        $this->createTable('{{%report_widget_result}}', [
            'id' => $this->primaryKey()->unsigned(),
            'add_on' => $this->json()->defaultValue(new Expression('(JSON_OBJECT())')),
            'widget_id' => $this->integer()->unsigned()->notNull(),
            'start_range' => $this->integer()->unsigned()->notNull(),
            'end_range' => $this->integer()->unsigned()->notNull(),
            'run_controller' => $this->string(256),
            'run_action' => $this->string(128),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->unsigned()->notNull(),
        ]);
        $this->createIndex('widget_result_ibfk_1', '{{%report_widget_result}}', ['widget_id']);
        $this->addForeignKey(
            'widget_result_ibfk_1',
            '{{%report_widget_result}}',
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
        $this->dropTable('{{%report_widget_result}}');
    }
}
