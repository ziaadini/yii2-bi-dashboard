<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_slave_id_to_widget
 */
class m230826_064956_add_slave_id_to_external_data extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }
    public function safeUp()
    {
        $this->dropForeignKey('external_data_value_FK_external_data_id', '{{%external_data_value}}');
        $this->addColumn('{{%external_data}}', 'slave_id', $this->tinyInteger()->unsigned()->notNull()->after('id'));
        $this->alterColumn('{{%external_data}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%external_data}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%external_data}}', ['id', 'slave_id']);
        $this->alterColumn('{{%external_data}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%external_data}}', 'slave_id');
        $this->alterColumn('{{%external_data}}', 'id', $this->primaryKey());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%external_data}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%external_data}}', 'id');
        $this->alterColumn('{{%report_page_widget}}', 'id', $this->integer()->append('PRIMARY KEY'));
        $this->dropForeignKey('external_data_value_FK_external_data_id', '{{%external_data_value}}');
    }
}
