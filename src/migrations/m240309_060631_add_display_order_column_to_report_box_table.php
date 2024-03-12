<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%report_box}}`.
 */
class m240309_060631_add_display_order_column_to_report_box_table extends Migration
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
        $this->addColumn('{{%report_box}}', 'display_order', $this->integer()->notNull()->after('id'));

        //Update display_order same as IDs
        $this->update('{{%report_box}}', ['display_order' => new \yii\db\Expression('id')]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%report_box}}', 'display_order');
    }
}
