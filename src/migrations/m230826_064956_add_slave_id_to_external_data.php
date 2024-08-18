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
        $this->addColumn('{{%external_data}}', 'slave_id', $this->Integer()->unsigned()->notNull()->after('id'));
        $this->alterColumn('{{%external_data}}', 'id', $this->integer());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%external_data}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%external_data}}', ['id', 'slave_id']);
        $this->alterColumn('{{%external_data}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
        $this->addForeignKey(
            'external_data_value_FK_external_data_id',
            '{{%external_data_value}}',
            'external_data_id',
            '{{%external_data}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }
    public function safeDown()
    {
        $this->dropForeignKey('external_data_value_FK_external_data_id', '{{%external_data_value}}');
        $this->alterColumn('{{%external_data}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%external_data}}');
        $this->dropColumn('{{%external_data}}', 'slave_id');
        $this->alterColumn('{{%external_data}}', 'id', $this->primaryKey());
        $this->alterColumn('{{%external_data}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
        $this->addForeignKey(
            'external_data_value_FK_external_data_id',
            '{{%external_data_value}}',
            'external_data_id',
            '{{%external_data}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }
}
