<?php


use yii\db\Migration;

/**
 * Class m230814_112418_create_table_model_class
 */
class m230814_112418_create_table_model_class extends Migration
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
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%report_model_class}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'model_class' => $this->string(128)->notNull(),
                'title' => $this->string(128)->notNull(),
                'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue('1'),
                'created_at' => $this->integer()->unsigned()->notNull(),
                'created_by' => $this->integer()->unsigned(),
                'updated_at' => $this->integer()->unsigned()->notNull(),
                'updated_by' => $this->integer()->unsigned(),
                'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue('0'),
            ],
            $tableOptions
        );
        $this->insert('{{%report_model_class}}', [
            'model_class' => 'ExternalDataValue',
            'title' => 'داده خارج از سیستم',
            'status' => 1,
            'created_at' => time(),
            'created_by' => null,
            'updated_at' => time(),
            'updated_by' => null,
            'deleted_at' => 0,
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%report_model_class}}');
    }
}
