<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_slave_id_to_widget
 */
class m230826_064951_add_slave_id_to_result_widget extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }
    public function safeUp()
    {
        $this->addColumn('{{%report_widget_result}}', 'slave_id', $this->tinyInteger()->unsigned()->notNull()->after('id'));
        $this->alterColumn('{{%report_widget_result}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_widget_result}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_widget_result}}', ['id', 'slave_id']);
        $this->alterColumn('{{%report_widget_result}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%report_widget_result}}', 'slave_id');
        $this->alterColumn('{{%report_widget_result}}', 'id', $this->primaryKey());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_widget_result}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_widget_result}}', 'id');
        $this->alterColumn('{{%report_page_widget}}', 'id', $this->integer()->append('PRIMARY KEY'));
    }
}
