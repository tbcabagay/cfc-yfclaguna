<?php

use yii\db\Schema;
use yii\db\Migration;

class m150911_134249_create_service_table extends Migration
{
    public function up()
    {
        $this->createTable('service', [
            'id' => $this->primaryKey(),
            'name' => $this->string(15)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('service');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
