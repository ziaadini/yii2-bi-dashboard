<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_slave_id_to_widget
 */
class m230826_064952_add_slave_id_to_page extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }

    public function safeUp()
    {
        $this->dropForeignKey('page_widget_ibfk_1', '{{%report_page_widget}}');
        $this->dropForeignKey('fk-sharing_page-page_id', '{{%report_sharing_page}}');
        $this->addColumn('{{%report_page}}', 'slave_id', $this->tinyInteger()->unsigned()->notNull()->after('id'));
        $this->alterColumn('{{%report_page}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_page}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_page}}', ['id', 'slave_id']);
        $this->alterColumn('{{%report_page}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
        $this->addForeignKey(
            'page_widget_ibfk_1',
            '{{%report_page_widget}}',
            'page_id',
            '{{%report_page}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-sharing_page-page_id',
            '{{%report_sharing_page}}',
            'page_id',
            '{{%report_page}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropColumn('{{%report_page}}', 'slave_id');
        $this->alterColumn('{{%report_page}}', 'id', $this->primaryKey());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_page}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_page}}', 'id');
        $this->alterColumn('{{%report_page_widget}}', 'id', $this->integer()->append('PRIMARY KEY'));
    }
}
