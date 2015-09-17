<?php

use yii\db\Schema;
use yii\db\Migration;

class m150914_072139_create_cluster_table extends Migration
{
    public function up()
    {
        $this->createTable('cluster', [
            'id' => $this->primaryKey(),
            'sector_id' => $this->integer()->notNull(),
            'label' => $this->string(30)->notNull(),
        ]);

        $this->addForeignKey('fk_sector_cluster', 'cluster', 'sector_id', 'sector', 'id', 'CASCADE', 'CASCADE');

        $this->insert('cluster', [
            'sector_id' => 1,
            'label' => 'East 1B',
        ]);

        $this->insert('cluster', [
            'sector_id' => 6,
            'label' => 'Los Banos',
        ]);

        $this->insert('cluster', [
            'sector_id' => 6,
            'label' => 'BayCal',
        ]);

        $this->insert('cluster', [
            'sector_id' => 6,
            'label' => 'C4',
        ]);
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropTable('cluster');
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
