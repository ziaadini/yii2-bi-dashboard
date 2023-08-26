<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_client_id_to_widget
 */
class m230826_064954_add_client_id_to_sharing_page extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%report_sharing_page}}', 'bi_client_id', $this->tinyInteger()->unsigned());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%report_sharing_page}}', 'bi_client_id');
    }
}
