<?php

use yii\db\Schema;
use yii\db\Migration;

class m150912_164856_create_auth_table extends Migration
{
    public function up()
    {
        $this->createTable('auth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string(255)->notNull(),
            'source_id' => $this->string(255)->notNull(),
        ]);

        $this->addForeignKey('fk_user_auth', 'auth', 'user_id', 'user', 'id', null, 'CASCADE');
    }

    public function down()
    {
        echo "dropping table `auth`";

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
