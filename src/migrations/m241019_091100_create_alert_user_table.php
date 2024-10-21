<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%alert_users}}`.
 */
class m241019_091100_create_alert_user_table extends Migration
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
        $this->createTable('{{%report_alert_user}}', [
            'id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'),
            'slave_id' => $this->integer()->unsigned()->notNull(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'alert_id' => $this->integer()->unsigned()->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->unsigned()->notNull(),
            'PRIMARY KEY(id, slave_id)',
        ]);

        $this->createIndex(
            '{{%idx-report_alert_user-user_id}}', '{{%report_alert_user}}', 'user_id'
        );

        // add foreign key for table `{{%report_user}}`
        $this->addForeignKey(
            '{{%fk-report_alert_user-user_id}}',
            '{{%report_alert_user}}',
            'user_id',
            '{{%report_user}}',
            'id',
            'RESTRICT'
        );

        // creates index for column `alert_id`
        $this->createIndex(
            '{{%idx-report_alert_user-alert_id}}',
            '{{%report_alert_user}}',
            'alert_id'
        );

        // add foreign key for table `{{%report_widget}}`
        $this->addForeignKey(
            '{{%fk-report_alert_user-alert_id}}',
            '{{%report_alert_user}}',
            'alert_id',
            '{{%report_alert}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-report_alert_user-alert_id}}', '{{%report_alert_user}}');
        $this->dropIndex('{{%idx-report_alert_user-alert_id}}', '{{%report_alert_user}}');
        $this->dropForeignKey('{{%fk-report_alert_user-user_id}}', '{{%report_alert_user}}');
        $this->dropIndex('{{%idx-report_alert_user-user_id}}', '{{%report_alert_user}}');

        $this->dropTable('{{%report_alert_user}}');
    }
}
