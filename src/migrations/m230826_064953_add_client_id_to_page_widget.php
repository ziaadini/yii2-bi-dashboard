<?php

use yii\db\Migration;

/**
 * Class m230826_064950_add_client_id_to_widget
 */
class m230826_064953_add_client_id_to_page_widget extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%report_page_widget}}', 'bi_client_id', $this->tinyInteger()->unsigned());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%report_page_widget}}', 'bi_client_id');
    }
}
