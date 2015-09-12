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
            'email' => $this->string(100)->notNull(),
            'status' => $this->smallInteger(3)->notNull(),
            'role' => $this->smallInteger(3)->notNull(),
            'is_deleted' => $this->boolean(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    public function down()
    {
        echo "dropping table `user`";

        $this->dropTable('user');
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