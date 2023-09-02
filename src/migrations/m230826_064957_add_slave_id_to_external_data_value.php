<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_slave_id_to_widget
 */
class m230826_064957_add_slave_id_to_external_data_value extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }
    public function safeUp()
    {
        $this->addColumn('{{%external_data_value}}', 'slave_id', $this->tinyInteger()->unsigned()->notNull()->after('id'));
        $this->alterColumn('{{%external_data_value}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%external_data_value}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%external_data_value}}', ['id', 'slave_id']);
        $this->alterColumn('{{%external_data_value}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
    }

    public function safeDown()
    {
        $this->alterColumn('{{%external_data_value}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%external_data_value}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%external_data_value}}', 'id');
        $this->dropColumn('{{%external_data_value}}', 'slave_id');
        $this->alterColumn('{{%external_data_value}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
    }

}
