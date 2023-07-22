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
            'access_key' => $this->string(64)->notNull()->unique(),
            'expire_time' => $this->integer()->unsigned()->defaultValue(0),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
            'created_by' => $this->integer()->unsigned()->notNull(),
            'updated_by' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
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