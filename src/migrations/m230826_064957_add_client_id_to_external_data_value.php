<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_client_id_to_widget
 */
class m230826_064957_add_client_id_to_external_data_value extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn('{{%external_data_value}}', 'bi_client_id', $this->tinyInteger()->unsigned());
        $this->createIndex('idx_unique_report_widget_id_client_id', '{{%external_data_value}}', ['id', 'bi_client_id'], true);
    }

    public function safeDown()
    {
        $this->dropIndex('idx_unique_external_data_value_id_client_id', '{{%external_data_value}}');
        $this->dropColumn('{{%external_data_value}}', 'bi_client_id');
    }
}
