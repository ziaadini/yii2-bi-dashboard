<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%report_box}}`.
 */
class m240312_064443_add_date_type_column_to_report_box_table extends Migration
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
        $this->addColumn('{{%report_box}}', 'date_type', $this->integer()->unsigned()->notNull()->after('range_type')->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%report_box}}', 'date_type');
    }
}
