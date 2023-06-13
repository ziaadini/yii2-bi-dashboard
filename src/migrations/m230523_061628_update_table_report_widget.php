<?php

use yii\db\Migration;

class m230523_061628_update_table_report_widget extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%report_widget}}', 'search_route', $this->string(128)->notNull()->after('created_by'));
        $this->addColumn('{{%report_widget}}', 'search_model_form_name', $this->string(128)->notNull()->after('search_route'));
        $this->alterColumn('{{%report_widget}}', 'search_model_class', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%report_widget}}', 'search_route');
        $this->dropColumn('{{%report_widget}}', 'search_model_form_name');
        $this->alterColumn('{{%report_widget}}', 'search_model_class', $this->smallInteger()->unsigned());
    }
}
