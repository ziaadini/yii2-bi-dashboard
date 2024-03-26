<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%report_page_widget}}`.
 */
class m240310_075720_add_display_order_column_to_report_page_widget_table extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%report_page_widget}}', 'display_order', $this->integer()->notNull()->after('widget_id'));

        //Update display_order same as IDs
        $this->update('{{%report_page_widget}}', ['display_order' => new \yii\db\Expression('id')]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%report_page_widget}}', 'display_order');
    }
}
