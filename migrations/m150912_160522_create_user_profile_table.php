<?php

use yii\db\Schema;
use yii\db\Migration;

class m150912_160522_create_user_profile_table extends Migration
{
    public function up()
    {
        $this->createTable('user_profile', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'family_name' => $this->string(100)->notNull(),
            'given_name' => $this->string(100)->notNull(),
            'image' => $this->string(300)->notNull(),
            'address' => $this->string(300),
            'birthday' => $this->date(),
            'joined_at' => $this->date(),
            'venue' => $this->string(200),
        ]);

        $this->addForeignKey('fk_user_userprofile', 'user_profile', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropTable('user_profile');
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
