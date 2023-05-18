<?php


use yii\db\Migration;


/**
 * Class m230517_063258_widget
 */
class m230517_063258_report_widget_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%report_widget}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'title' => $this->string(128)->notNull(),
            'description' => $this->string(255)->Null(),
            'search_model_class' => $this->smallInteger()->unsigned(),
            'search_model_method' => $this->string(128)->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
            'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'search_model_run_result_view' => $this->string(128),
            'range_type' => $this->tinyInteger()->unsigned(),
            'visibility' => $this->tinyInteger()->unsigned(),
            'add_on' => $this->json()->defaultValue(new Expression('(JSON_OBJECT())')),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_by' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%report_widget}}');
    }

}
