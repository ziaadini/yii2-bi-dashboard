<?php

use yii\db\Migration;

class m230522_094157_create_table_report_model_class extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%report_model_class}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'title' => $this->string(128)->notNull(),
                'search_model_class' => $this->string(128)->notNull(),
                'search_model_method' => $this->string(128),
                'search_model_run_result_view' => $this->string(128),
                'status' => $this->integer()->notNull()->defaultValue(1),
                'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
                'updated_at' => $this->integer()->unsigned()->notNull(),
                'created_at' => $this->integer()->unsigned()->notNull(),
                'updated_by' => $this->integer()->unsigned()->notNull(),
                'created_by' => $this->integer()->unsigned()->notNull(),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%report_model_class}}');
    }
}
