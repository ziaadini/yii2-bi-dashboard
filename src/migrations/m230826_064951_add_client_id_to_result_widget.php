<?php



use yii\db\Migration;

/**
 * Class m230826_064950_add_client_id_to_widget
 */
class m230826_064951_add_client_id_to_result_widget extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%report_widget_result}}', 'bi_client_id', $this->tinyInteger()->unsigned());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%report_widget_result}}', 'bi_client_id');
    }
}
