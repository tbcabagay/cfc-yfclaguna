<?php

use yii\db\Schema;
use yii\db\Migration;

class m150914_134133_create_announcement_table extends Migration
{
    public function up()
    {
        $this->createTable('announcement', [
            'id' => $this->bigInteger() . ' AUTO_INCREMENT',
            'PRIMARY KEY(`id`)',
        ]);

        //$this->addForeignKey('fk_user_userprofile', 'user_profile', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropTable('announcement');
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
