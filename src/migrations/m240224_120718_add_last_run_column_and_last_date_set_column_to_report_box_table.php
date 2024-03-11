<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%report_box}}`.
 */
class m240224_120718_add_last_run_column_and_last_date_set_column_to_report_box_table extends Migration
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
        $this->addColumn('{{%report_box}}', 'last_run', $this->integer()->unsigned()->notNull()->after('range_type')->defaultValue(0));
        $this->addColumn('{{%report_box}}', 'last_date_set', $this->integer()->unsigned()->notNull()->after('range_type'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%report_box}}', 'last_run');
        $this->dropColumn('{{%report_box}}', 'last_date_set');
    }
}
