<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_client_id_to_widget
 */
class m230826_064954_add_client_id_to_sharing_page extends Migration
{

    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn('{{%report_sharing_page}}', 'bi_client_id', $this->tinyInteger()->unsigned());
        $this->createIndex('idx_unique_report_widget_id_client_id', '{{%report_sharing_page}}', ['id', 'bi_client_id'], true);
    }

    public function safeDown()
    {
        $this->dropIndex('idx_unique_report_sharing_page_id_client_id', '{{%report_sharing_page}}');
        $this->dropColumn('{{%report_sharing_page}}', 'bi_client_id');
    }
}
