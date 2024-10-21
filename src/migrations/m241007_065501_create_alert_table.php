<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%alert}}`.
 */
class m241007_065501_create_alert_table extends Migration
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
        $this->createTable('{{%report_alert}}', [
            'id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'),
            'slave_id' => $this->integer()->unsigned()->notNull(),
            'widget_id' => $this->integer()->unsigned()->notNull(),
            'widget_field' => $this->string(64)->notNull(),
            'title' => $this->string(128),
            'description' => $this->string(128)->notNull(),
            'ceiling' => $this->decimal(16),
            'floor' => $this->decimal(16),
            'notification_type' => $this->tinyInteger()->notNull()->defaultValue(0),
            'state' => $this->tinyInteger()->notNull()->defaultValue(0),
            'seen' => $this->tinyInteger()->notNull()->defaultValue(0),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->unsigned()->notNull(),
            'PRIMARY KEY(id, slave_id)',
        ]);

        // creates index for column `widget_id`
        $this->createIndex(
            '{{%idx-report_alert-widget_id}}',
            '{{%report_alert}}',
            'widget_id'
        );

        // add foreign key for table `{{%report_widget}}`
        $this->addForeignKey(
            '{{%fk-report_alert-widget_id}}',
            '{{%report_alert}}',
            'widget_id',
            '{{%report_widget}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%report_widget}}`
        $this->dropForeignKey(
            '{{%fk-report_alert-widget_id}}',
            '{{%report_alert}}'
        );

        // drops index for column `widget_id`
        $this->dropIndex(
            '{{%idx-report_alert-widget_id}}',
            '{{%report_alert}}'
        );

        $this->dropTable('{{%report_alert}}');
    }
}
