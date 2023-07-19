<?php


use yii\db\Migration;

/**
 * Class m230717_115527_sharing_page_table
 */
class m230717_115527_sharing_page_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('sharing_page', [
            'id' => $this->primaryKey()->unsigned(),
            'page_id' => $this->integer()->unsigned()->notNull(),
            'access_key' => $this->string(64)->notNull(),
            'expire_time' => $this->integer()->unsigned()->defaultValue(0),
            'created_by' => $this->integer()->unsigned(),
            'updated_by' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
            'deleted_at' => $this->integer()->unsigned()->defaultValue(0),
        ]);

        $this->createIndex('idx-sharing_page-page_id', 'sharing_page', 'page_id');
        $this->addForeignKey(
            'fk-sharing_page-page_id',
            'sharing_page',
            'page_id',
            'report_page',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropIndex('idx-sharing_page-page_id', 'sharing_page');
        $this->dropForeignKey('fk-sharing_page-page_id', 'sharing_page');
        $this->dropTable('sharing_page');

    }
}
