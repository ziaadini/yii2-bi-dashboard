<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m241015_052343_create_user_table extends Migration
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
        $this->createTable('{{%report_user}}', [
            'id' => $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'),
            'slave_id' => $this->integer()->unsigned()->notNull(),
            'first_name' => $this->string(64)->notNull(),
            'last_name' => $this->string(64)->notNull(),
            'phone_number' => $this->string(15)->notNull(),
            'email' => $this->string(64)->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->unsigned()->notNull(),
            'PRIMARY KEY(id, slave_id)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%report_user}}');
    }
}
