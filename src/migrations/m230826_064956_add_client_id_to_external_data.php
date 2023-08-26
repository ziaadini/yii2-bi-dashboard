<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_client_id_to_widget
 */
class m230826_064956_add_client_id_to_external_data extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn('{{%external_data}}', 'bi_client_id', $this->tinyInteger()->unsigned());
        $this->createIndex('idx_unique_report_widget_id_client_id', '{{%external_data}}', ['id', 'bi_client_id'], true);
    }

    public function safeDown()
    {
        $this->dropIndex('idx_unique_external_data_id_client_id', '{{%external_data}}');
        $this->dropColumn('{{%external_data}}', 'bi_client_id');
    }
}
