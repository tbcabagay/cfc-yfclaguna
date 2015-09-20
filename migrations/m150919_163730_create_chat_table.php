<?php

use yii\db\Schema;
use yii\db\Migration;

class m150919_163730_create_chat_table extends Migration
{
    public function up()
    {
        $this->createTable('chat', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(),
            'message' => $this->text(),
            'updateDate' => $this->timestamp()->notNull() . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
    }

    public function down()
    {
        $this->dropTable('chat');
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
