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
        ]);

        $this->addForeignKey('fk_user_userprofile', 'user_profile', 'user_id', 'user', 'id', null, 'CASCADE');
    }

    public function down()
    {
        echo "dropping table `user_profile`";

        $this->dropTable('user_profile');
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
