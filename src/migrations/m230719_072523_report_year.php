<?php

use yii\db\Migration;

/**
 * Class m230719_072523_report_year
 */
class m230719_072523_report_year extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }

    public function safeUp()
    {
        $this->createTable('{{%report_year}}', [
            'id' => $this->primaryKey()->unsigned(),
            'year' => $this->integer()->unsigned()->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->unsigned()->null(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'updated_by' => $this->integer()->unsigned()->null(),
            'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ]);

        // Create 10 Last Years
        $now = yii::$app->pdate->jgetdate();
        for ($i = 0; $i < 10; $i++) {
            $year = (int)$now['year'] - $i;
            $this->insert('{{%report_year}}', ['year' => $year, 'created_at' => time(), 'updated_at' => time()]);
        }
        $this->createIndex('unique-year-deleted_at', '{{%report_year}}', ['year', 'deleted_at'], true);
    }

    public function safeDown()
    {
        $this->dropIndex('unique-year-deleted_at', '{{%report_year}}');
        $this->dropTable('{{%report_year}}');
    }
}