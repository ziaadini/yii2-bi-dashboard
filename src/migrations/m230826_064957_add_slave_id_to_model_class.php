<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_slave_id_to_widget
 */
class m230826_064957_add_slave_id_to_model_class extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }
    public function safeUp()
    {
        $this->addColumn('{{%report_model_class}}', 'slave_id', $this->tinyInteger()->unsigned()->notNull()->after('id'));
        $this->alterColumn('{{%report_model_class}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_model_class}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_model_class}}', ['id', 'slave_id']);
        $this->alterColumn('{{%report_model_class}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
    }

    public function safeDown()
    {
        $this->alterColumn('{{%report_model_class}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_model_class}}');
        $this->dropColumn('{{%report_model_class}}', 'slave_id');
        $this->alterColumn('{{%report_model_class}}', 'id', $this->primaryKey());
        $this->alterColumn('{{%report_model_class}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
    }

}
