<?php

use yii\db\Migration;

/**
 * Create years for other slave_ids.
 */
class m240311_093645_create_years_for_slave_to_report_year_table extends Migration
{
    public $yearTable = '{{%report_year}}';
    public $widgetTable = '{{%report_widget}}';
    
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

        $now = yii::$app->pdate->jgetdate();

        $this->dropIndex('unique-year-deleted_at', $this->yearTable);
        $this->createIndex('unique-slave-year-deleted_at', $this->yearTable, ['slave_id', 'year', 'deleted_at'], true);

        // Get all distinct slave_ids
        $slaveIds = $this->db->createCommand("SELECT DISTINCT slave_id FROM $this->widgetTable")->queryColumn();

        // Create 10 Last Years for each slave_id except slave_id = 1
        foreach ($slaveIds as $slaveId) {
            if ($slaveId == 1)
                continue;
            for ($i = 10; $i >= 0; $i--) {
                $year = (int)$now['year'] - $i;
                $this->insert($this->yearTable, [
                    'year' => $year,
                    'slave_id' => $slaveId,
                    'created_at' => time(),
                    'updated_at' => time()
                ]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //delete all rows except slave_id = 1
        $this->db->createCommand()->delete($this->yearTable,
            ['not', ['slave_id' => 1]]
        )->execute();

        $this->dropIndex('unique-slave-year-deleted_at', $this->yearTable);
        $this->createIndex('unique-year-deleted_at', $this->yearTable, ['year', 'deleted_at'], true);
    }
}
