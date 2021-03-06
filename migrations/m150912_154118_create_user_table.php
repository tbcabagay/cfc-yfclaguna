<?php

use yii\db\Schema;
use yii\db\Migration;

class m150912_154118_create_user_table extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'auth_key' => $this->string(32)->notNull(),
            'division_id' => $this->integer(),
            'division_label' => $this->string(20),
            'service_id' => $this->smallInteger()->notNull(),
            'cluster_id' => $this->integer(),
            'username' => $this->string(50),
            'password_hash' => $this->string(100),
            'email' => $this->string(255)->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'role' => $this->string(20)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->addForeignKey('fk_service_user', 'user', 'service_id', 'service', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropTable('user');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
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
