<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_slave_id_to_widget
 */
class m230826_064950_add_slave_id_to_widget extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }

    public function safeUp()
    {
        $this->dropForeignKey('page_widget_ibfk_2', '{{%report_page_widget}}');
        $this->addColumn('{{%report_widget}}', 'slave_id', $this->tinyInteger()->unsigned()->notNull()->after('id'));
        $this->alterColumn('{{%report_widget}}', 'id', $this->integer());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_widget}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_widget}}', ['id', 'slave_id']);
    }

    public function safeDown()
    {
        $this->dropColumn('{{%report_widget}}', 'slave_id');
        $this->alterColumn('{{%report_widget}}', 'id', $this->primaryKey());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_widget}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_widget}}', 'id');
    }
}
