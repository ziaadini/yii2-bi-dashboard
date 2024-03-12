<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%report_year}}`.
 */
class m240302_082109_add_slave_id_column_to_report_year_table extends Migration
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
        $this->addColumn('{{%report_year}}', 'slave_id', $this->Integer()->unsigned()->notNull()->after('id')->defaultValue(1));
        $this->alterColumn('{{%report_year}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_year}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_year}}', ['id', 'slave_id']);
        $this->alterColumn('{{%report_year}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%report_year}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_year}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_year}}', 'id');
        $this->dropColumn('{{%report_year}}', 'slave_id');
        $this->alterColumn('{{%report_year}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
    }
}
