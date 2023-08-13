<?php


use yii\db\Migration;

/**
 * Class m230719_072545_create_table_external_data
 */
class m230719_072645_create_table_external_data_value extends Migration
{
    public function init()
    {
        $this->db = 'biDB';
        parent::init();
    }
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%external_data_value}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'external_data_id' => $this->integer()->unsigned()->notNull(),
                'value' => $this->decimal(20, 0)->unsigned()->notNull(),
                'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue('1'),
                'created_at' => $this->integer()->unsigned()->notNull(),
                'created_by' => $this->integer()->unsigned()->notNull(),
                'updated_at' => $this->integer()->unsigned()->notNull(),
                'updated_by' => $this->integer()->unsigned()->notNull(),
                'deleted_at' => $this->integer()->unsigned()->notNull()->defaultValue('0'),
            ],
            $tableOptions
        );
        $this->addForeignKey(
            'external_data_value_FK_external_data_id',
            '{{%external_data_value}}',
            ['external_data_id'],
            '{{%external_data}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%external_data_value}}');
    }
}