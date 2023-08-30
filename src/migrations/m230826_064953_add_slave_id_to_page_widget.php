<?php

use yii\db\Migration;

/**
 * Class m230826_064950_add_slave_id_to_widget
 */
class m230826_064953_add_slave_id_to_page_widget extends Migration
{

    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn('{{%report_page_widget}}', 'slave_id', $this->Integer()->unsigned()->notNull()->after('id'));
        $this->alterColumn('{{%report_page_widget}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_page_widget}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_page_widget}}', ['id', 'slave_id']);
        $this->alterColumn('{{%report_page_widget}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
    }

    public function safeDown()
    {
        $this->alterColumn('{{%report_page_widget}}', 'id', $this->integer()->unsigned()->notNull());
        $this->dropPrimaryKey('PRIMARYKEY', '{{%report_page_widget}}');
        $this->addPrimaryKey('PRIMARYKEY', '{{%report_page_widget}}', 'id');
        $this->dropColumn('{{%report_page_widget}}', 'slave_id');
        $this->alterColumn('{{%report_page_widget}}', 'id', $this->integer()->unsigned()->notNull()->append('AUTO_INCREMENT'));
    }
}
