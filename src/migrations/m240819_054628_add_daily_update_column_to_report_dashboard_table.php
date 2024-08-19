<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%report_dashboard}}`.
 */
class m240819_054628_add_daily_update_column_to_report_dashboard_table extends Migration
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
        $this->addColumn('{{%report_dashboard}}', 'daily_update', $this->tinyInteger()->notNull()->after('status')->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%report_dashboard}}', 'daily_update');
    }
}
