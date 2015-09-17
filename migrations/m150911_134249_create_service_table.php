<?php

use yii\db\Schema;
use yii\db\Migration;

class m150911_134249_create_service_table extends Migration
{
    public function up()
    {
        $this->createTable('service', [
            'id' => $this->smallInteger() . ' AUTO_INCREMENT PRIMARY KEY',
            'name' => $this->string(30)->notNull(),
        ]);

        $this->insert('service', [
            'name' => 'Head',
        ]);

        $this->insert('service', [
            'name' => 'Couple Coordinator',
        ]);

        $this->insert('service', [
            'name' => 'Member',
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
