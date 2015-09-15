<?php

use yii\db\Schema;
use yii\db\Migration;

class m150915_032450_create_document_table extends Migration
{
    public function up()
    {
        $this->createTable('document', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(100)->notNull(),
            'remarks' => $this->string(500)->notNull(),
            'attachment' => $this->string(500)->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'is_deleted' => $this->boolean()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'time_difference' => $this->integer(),
        ]);

        $this->addForeignKey('fk_user_document', 'document', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropTable('document');
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
