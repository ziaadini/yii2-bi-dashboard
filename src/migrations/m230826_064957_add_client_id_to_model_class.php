<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_client_id_to_widget
 */
class m230826_064957_add_client_id_to_model_class extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%report_model_class}}', 'bi_client_id', $this->tinyInteger()->unsigned());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%report_model_class}}', 'bi_client_id');
    }
}
