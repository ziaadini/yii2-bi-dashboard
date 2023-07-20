<?php

use yii;
use yii\db\Migration;

/**
 * Class m230719_072523_report_year
 */
class m230719_072523_report_year extends Migration
{
    public function safeUp()
    {
        $this->createTable('report_year', [
            'id' => $this->primaryKey()->unsigned(),
            'year' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(time()), // Set default value as current time
            'created_by' => $this->integer()->unsigned()->null(),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(time()), // Set default value as current time
            'updated_by' => $this->integer()->unsigned()->null(),
            'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ]);

        // Create 10 Last Years
        $now = yii::$app->pdate->jgetdate();
        for ($i = 0; $i < 10; $i++) {
            $year = (int)$now['year'] - $i;
            $this->insert('report_year', ['year' => $year]);
        }
    }

    public function safeDown()
    {
        $this->dropTable('report_year');
    }
}