<?php

use yii\db\Schema;
use yii\db\Migration;

class m150914_134149_create_comment_table extends Migration
{
    public function up()
    {
        $this->createTable('comment', [
            'id' => $this->bigInteger() . ' AUTO_INCREMENT PRIMARY KEY',
            'announcement_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
        ]);

        $this->addForeignKey('fk_announcement_comment', 'comment', 'announcement_id', 'announcement', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_comment', 'comment', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropTable('comment');
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
