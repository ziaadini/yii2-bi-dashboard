<?php

use yii\db\Migration;
use yii\db\Expression;

/**
 * Handles the creation of table `{{%fired_alert}}`.
 */
class m241008_102640_create_fired_alert_table extends Migration
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
        $this->createTable('{{%report_fired_alert}}', [
            'id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'),
            'slave_id' => $this->integer()->unsigned()->notNull(),
            'alert_id' => $this->integer()->unsigned()->notNull(),
            'box_id' => $this->integer()->unsigned()->notNull(),
            'dashboard_id' => $this->integer()->unsigned()->notNull(),
            'widget_result_alerting' => $this->json()->defaultValue(new Expression('(JSON_OBJECT())')),
            'widget_result_id' => $this->integer()->unsigned()->notNull(),
            'widget_id' => $this->integer()->unsigned()->notNull(),
            'widget_field' => $this->string(64)->notNull(),
            'seen_status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(0),
            'seen_time' => $this->integer()->unsigned(),
            'seen_by' => $this->integer()->unsigned(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->unsigned()->notNull(),
            'PRIMARY KEY(id, slave_id)',
        ]);

        // creates index for column `alert_id`
        $this->createIndex(
            '{{%idx-report_fired_alert-alert_id}}',
            '{{%report_fired_alert}}',
            'alert_id'
        );

        // add foreign key for table `{{%report_alert}}`
        $this->addForeignKey(
            '{{%fk-report_fired_alert-alert_id}}',
            '{{%report_fired_alert}}',
            'alert_id',
            '{{%report_alert}}',
            'id',
            'RESTRICT'
        );

        // creates index for column `box_id`
        $this->createIndex(
            '{{%idx-report_fired_alert-box_id}}',
            '{{%report_fired_alert}}',
            'box_id'
        );

        // add foreign key for table `{{%report_box}}`
        $this->addForeignKey(
            '{{%fk-report_fired_alert-box_id}}',
            '{{%report_fired_alert}}',
            'box_id',
            '{{%report_box}}',
            'id',
            'RESTRICT'
        );

        // creates index for column dashboard_id
        $this->createIndex(
            '{{%idx-report_fired_alert-dashboard_id}}',
            '{{%report_fired_alert}}',
            'dashboard_id'
        );

        // add foreign key for table {{%report_dashboard}}
        $this->addForeignKey(
            '{{%fk-report_fired_alert-dashboard_id}}',
            '{{%report_fired_alert}}',
            'dashboard_id',
            '{{%report_dashboard}}',
            'id',
            'RESTRICT'
        );

        // creates index for column widget_result_id
        $this->createIndex(
            '{{%idx-report_fired_alert-widget_result_id}}',
            '{{%report_fired_alert}}',
            'widget_result_id'
        );

        // add foreign key for table {{%report_widget_result}}
        $this->addForeignKey(
            '{{%fk-report_fired_alert-widget_result_id}}',
            '{{%report_fired_alert}}',
            'widget_result_id',
            '{{%report_widget_result}}',
            'id',
            'RESTRICT'
        );

        // creates index for column widget_id
        $this->createIndex(
            '{{%idx-report_fired_alert-widget_id}}',
            '{{%report_fired_alert}}',
            'widget_id'
        );

        // add foreign key for table {{%report_widget}}
        $this->addForeignKey(
            '{{%fk-report_fired_alert-widget_id}}',
            '{{%report_fired_alert}}',
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
        // Drops foreign keys for related tables
        $this->dropForeignKey('{{%fk-report_fired_alert-alert_id}}', '{{%report_fired_alert}}');
        $this->dropForeignKey('{{%fk-report_fired_alert-box_id}}', '{{%report_fired_alert}}');
        $this->dropForeignKey('{{%fk-report_fired_alert-dashboard_id}}', '{{%report_fired_alert}}');
        $this->dropForeignKey('{{%fk-report_fired_alert-widget_result_id}}', '{{%report_fired_alert}}');
        $this->dropForeignKey('{{%fk-report_fired_alert-widget_id}}', '{{%report_fired_alert}}');

        // Drops indexes for related tables
        $this->dropIndex('{{%idx-report_fired_alert-alert_id}}', '{{%report_fired_alert}}');
        $this->dropIndex('{{%idx-report_fired_alert-box_id}}', '{{%report_fired_alert}}');
        $this->dropIndex('{{%idx-report_fired_alert-dashboard_id}}', '{{%report_fired_alert}}');
        $this->dropIndex('{{%idx-report_fired_alert-widget_result_id}}', '{{%report_fired_alert}}');
        $this->dropIndex('{{%idx-report_fired_alert-widget_id}}', '{{%report_fired_alert}}');

        // Drops the table itself
        $this->dropTable('{{%report_fired_alert}}');
    }
}
