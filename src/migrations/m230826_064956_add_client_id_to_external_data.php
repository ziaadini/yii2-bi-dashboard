<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_client_id_to_widget
 */
class m230826_064956_add_client_id_to_external_data extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%external_data}}', 'bi_client_id', $this->tinyInteger()->unsigned());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%external_data}}', 'bi_client_id');
    }
}
