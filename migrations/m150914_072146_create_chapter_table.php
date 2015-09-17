<?php

use yii\db\Schema;
use yii\db\Migration;

class m150914_072146_create_chapter_table extends Migration
{
    public function up()
    {
        $this->createTable('chapter', [
            'id' => $this->primaryKey(),
            'cluster_id' => $this->integer()->notNull(),
            'label' => $this->string(30)->notNull(),
        ]);

        $this->addForeignKey('fk_cluster_chapter', 'chapter', 'cluster_id', 'cluster', 'id', 'CASCADE', 'CASCADE');

        $this->insert('chapter', [
            'cluster_id' => 2,
            'label' => 'San Antonio',
        ]);

        $this->insert('chapter', [
            'cluster_id' => 2,
            'label' => 'St. Therese - UPLB',
        ]);

        $this->insert('chapter', [
            'cluster_id' => 2,
            'label' => 'Immaculate Concepcion',
        ]);

        $this->insert('chapter', [
            'cluster_id' => 4,
            'label' => 'Cathedral-Concepcion',
        ]);

        $this->insert('chapter', [
            'cluster_id' => 4,
            'label' => 'Calihan-San Gabriel',
        ]);
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropTable('chapter');
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
