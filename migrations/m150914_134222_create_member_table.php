<?php

use yii\db\Schema;
use yii\db\Migration;

class m150914_134222_create_member_table extends Migration
{
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'auth_key' => $this->string(32)->notNull(),
            'service_id' => $this->smallInteger()->notNull(),
            'cluster_id' => $this->integer()->notNull(),
            'username' => $this->string(50)->notNull(),
            'password_hash' => $this->string(100)->notNull(),
            'family_name' => $this->string(100)->notNull(),
            'given_name' => $this->string(100)->notNull(),
            'address' => $this->string(300)->notNull(),
            'email' => $this->string(255)->notNull(),
            'birthday' => $this->date()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'image' => $this->string(300),
            'joined_at' => $this->date(),
            'venue' => $this->string(200),
        ]);

        $this->addForeignKey('fk_service_member', 'member', 'service_id', 'service', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_cluster_member', 'member', 'cluster_id', 'cluster', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropTable('member');
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
