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
        $this->dropForeignKey('widget_result_ibfk_1', '{{%report_widget_result}}');
        $this->addColumn('{{%report_widget}}', 'slave_id', $this->tinyInteger()->unsigned()->notNull()->after('id'));
        $this->alterColumn('{{%report_widget}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_widget}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_widget}}', ['id', 'slave_id']);
        $this->alterColumn('{{%report_widget}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
        $this->addForeignKey(
            'page_widget_ibfk_2',
            '{{%report_page_widget}}',
            'widget_id',
            '{{%report_widget}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'widget_result_ibfk_1',
            '{{%report_widget_result}}',
            'widget_id',
            '{{%report_widget}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropColumn('{{%report_widget}}', 'slave_id');
        $this->alterColumn('{{%report_widget}}', 'id', $this->primaryKey());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_widget}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_widget}}', 'id');
        $this->alterColumn('{{%report_page_widget}}', 'id', $this->integer()->append('PRIMARY KEY'));
        $this->dropForeignKey('page_widget_ibfk_2', '{{%report_page_widget}}');
        $this->dropForeignKey('widget_result_ibfk_1', '{{%report_widget_result}}');
    }
}
