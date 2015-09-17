<?php

use yii\db\Schema;
use yii\db\Migration;

class m150914_072130_create_sector_table extends Migration
{
    public function up()
    {
        $this->createTable('sector', [
            'id' => $this->primaryKey(),
            'provincial_id' => $this->integer()->notNull(),
            'label' => $this->string(30)->notNull(),
        ]);

        $this->addForeignKey('fk_provincial_sector', 'sector', 'provincial_id', 'provincial', 'id', 'CASCADE', 'CASCADE');

        $this->insert('sector', [
            'provincial_id' => 1,
            'label' => 'East 1',
        ]);

        $this->insert('sector', [
            'provincial_id' => 1,
            'label' => 'East 2',
        ]);

        $this->insert('sector', [
            'provincial_id' => 1,
            'label' => 'East 3',
        ]);

        $this->insert('sector', [
            'provincial_id' => 1,
            'label' => 'East 4',
        ]);

        $this->insert('sector', [
            'provincial_id' => 1,
            'label' => 'Central 1',
        ]);

        $this->insert('sector', [
            'provincial_id' => 1,
            'label' => 'Central 2',
        ]);

        $this->insert('sector', [
            'provincial_id' => 1,
            'label' => 'West 1',
        ]);

        $this->insert('sector', [
            'provincial_id' => 1,
            'label' => 'West 2',
        ]);
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropTable('sector');
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
