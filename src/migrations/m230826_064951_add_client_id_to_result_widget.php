<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_client_id_to_widget
 */
class m230826_064951_add_client_id_to_result_widget extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn('{{%report_widget_result}}', 'bi_client_id', $this->tinyInteger()->unsigned());
        $this->createIndex('idx_unique_report_widget_id_client_id', '{{%report_widget_result}}', ['id', 'bi_client_id'], true);
    }

    public function safeDown()
    {
        $this->dropIndex('idx_unique_report_widget_result_id_client_id', '{{%report_widget_result}}');
        $this->dropColumn('{{%report_widget_result}}', 'bi_client_id');
    }
}
