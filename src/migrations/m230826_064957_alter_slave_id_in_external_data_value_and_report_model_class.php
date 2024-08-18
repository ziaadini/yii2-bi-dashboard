<?php


use yii\db\Migration;

/**
 * Class m230826_064957_alter_slave_id_in_external_data_value_and_report_model_class
 */
class m230826_064957_alter_slave_id_in_external_data_value_and_report_model_class extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }
    
    public function safeUp()
    {
        $this->alterColumn('{{%report_model_class}}', 'slave_id', $this->integer()->unsigned()->notNull());
        $this->alterColumn('{{%external_data_value}}', 'slave_id', $this->integer()->unsigned()->notNull());
    }

    public function safeDown()
    {
        $this->alterColumn('{{%report_model_class}}', 'slave_id', $this->tinyInteger()->unsigned()->notNull());
        $this->alterColumn('{{%external_data_value}}', 'slave_id', $this->tinyInteger()->unsigned()->notNull());
    }
}