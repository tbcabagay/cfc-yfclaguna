<?php

use yii\db\Schema;
use yii\db\Migration;

class m150915_032510_create_document_status_table extends Migration
{
    public function up()
    {
        $this->createTable('document_status', [
            'id' => $this->bigInteger() . ' AUTO_INCREMENT PRIMARY KEY',
            'document_id' => $this->integer()->notNull(),
            'from_id' => $this->integer()->notNull(),
            'from_label' => $this->string(20)->notNull(),
            'to_id' => $this->integer()->notNull(),
            'to_label' => $this->string(20)->notNull(),
            'remarks' => $this->string(500),
            'received_by' => $this->integer(),
            'received_at' => $this->dateTime(),
            'released_by' => $this->integer(),
            'released_at' => $this->dateTime(),
            'action' => $this->smallInteger(),
            'attachment' => $this->string(500),
            'time_difference' => $this->integer(),
        ]);

        $this->addForeignKey('fk_document_document_status', 'document_status', 'document_id', 'document', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_document_status_receive', 'document_status', 'received_by', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_user_document_status_release', 'document_status', 'released_by', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropTable('document_status');
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
