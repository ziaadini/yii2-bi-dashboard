<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_client_id_to_widget
 */
class m230826_064957_add_client_id_to_external_data_value extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%external_data_value}}', 'bi_client_id', $this->tinyInteger()->unsigned());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%external_data_value}}', 'bi_client_id');
    }
}
