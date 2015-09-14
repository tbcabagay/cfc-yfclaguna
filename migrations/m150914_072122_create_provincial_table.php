<?php

use yii\db\Schema;
use yii\db\Migration;

class m150914_072122_create_provincial_table extends Migration
{
    public function up()
    {
        $this->createTable('provincial', [
            'id' => $this->primaryKey(),
            'label' => $this->string(30)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('provincial');
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
