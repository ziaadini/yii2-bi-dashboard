<?php

use yii\db\Migration;

/**
 * Class m230826_064959_fix_forien_keys_with_slave_id
 */
class m230826_064959_fix_forien_keys_with_slave_id extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }
    
    public function safeUp()
    {
        $this->dropForeignKey('external_data_value_FK_external_data_id', '{{%external_data_value}}');

        $this->addForeignKey(
            'external_data_value_FK_external_data_id',
            '{{%external_data_value}}',
            ['external_data_id', 'slave_id'],
            '{{%external_data}}',
            ['id', 'slave_id'],
            'RESTRICT',
            'RESTRICT'
        );

        $this->dropForeignKey('page_widget_ibfk_1', '{{%report_page_widget}}');

        $this->addForeignKey(
            'page_widget_ibfk_1',
            '{{%report_page_widget}}',
            ['page_id', 'slave_id'],
            '{{%report_page}}',
            ['id', 'slave_id'],
            'RESTRICT',
            'RESTRICT'
        );

        $this->dropForeignKey('page_widget_ibfk_2', '{{%report_page_widget}}');

        $this->addForeignKey(
            'page_widget_ibfk_2',
            '{{%report_page_widget}}',
            ['widget_id', 'slave_id'],
            '{{%report_widget}}',
            ['id', 'slave_id'],
            'RESTRICT',
            'RESTRICT'
        );

        $this->dropForeignKey('widget_result_ibfk_1', '{{%report_widget_result}}');

        $this->addForeignKey(
            'widget_result_ibfk_1',
            '{{%report_widget_result}}',
            ['widget_id', 'slave_id'],
            '{{%report_widget}}',
            ['id', 'slave_id'],
            'RESTRICT',
            'RESTRICT'
        );

        $this->dropForeignKey('fk-sharing_page-page_id', '{{%report_sharing_page}}');

        $this->addForeignKey(
            'fk-sharing_page-page_id',
            '{{%report_sharing_page}}',
            ['page_id', 'slave_id'],
            '{{%report_page}}',
            ['id', 'slave_id'],
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('external_data_value_FK_external_data_id', '{{%external_data_value}}');

        $this->addForeignKey(
            'external_data_value_FK_external_data_id',
            '{{%external_data_value}}',
            'external_data_id',
            '{{%external_data}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->dropForeignKey('page_widget_ibfk_1', '{{%report_page_widget}}');

        $this->addForeignKey(
            'page_widget_ibfk_1',
            '{{%report_page_widget}}',
            'page_id',
            '{{%report_page}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->dropForeignKey('page_widget_ibfk_2', '{{%report_page_widget}}');

        $this->addForeignKey(
            'page_widget_ibfk_2',
            '{{%report_page_widget}}',
            'widget_id',
            '{{%report_widget}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->dropForeignKey('widget_result_ibfk_1', '{{%report_widget_result}}');

        $this->addForeignKey(
            'widget_result_ibfk_1',
            '{{%report_widget_result}}',
            'widget_id',
            '{{%report_widget}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->dropForeignKey('fk-sharing_page-page_id', '{{%report_sharing_page}}');

        $this->addForeignKey(
            'fk-sharing_page-page_id',
            '{{%report_sharing_page}}',
            'page_id',
            '{{%report_page}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }
}
