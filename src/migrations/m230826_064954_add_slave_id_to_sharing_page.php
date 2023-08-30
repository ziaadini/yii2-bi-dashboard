<?php


use yii\db\Migration;

/**
 * Class m230826_064950_add_slave_id_to_widget
 */
class m230826_064954_add_slave_id_to_sharing_page extends Migration
{

    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }
    public function safeUp()
    {
        $this->addColumn('{{%report_sharing_page}}', 'slave_id', $this->Integer()->unsigned()->notNull()->after('id'));
        $this->alterColumn('{{%report_sharing_page}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_sharing_page}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_sharing_page}}', ['id', 'slave_id']);
        $this->alterColumn('{{%report_sharing_page}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
    }

    public function safeDown()
    {
        $this->alterColumn('{{%report_sharing_page}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_sharing_page}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_sharing_page}}', 'id');
        $this->dropColumn('{{%report_sharing_page}}', 'slave_id');
        $this->alterColumn('{{%report_sharing_page}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
    }
}
