<?php

namespace thienhungho\TermManagement\migrations;

use yii\db\Schema;

class m181107_090101_term_relationships extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%term_relationships}}', [
            'id'        => $this->primaryKey(),
            'term_id'   => $this->integer(19)->notNull(),
            'term_type' => $this->string(255)->notNull(),
            'obj_id'    => $this->integer(19)->notNull(),
            'obj_type'  => $this->string(255)->notNull(),
            'FOREIGN KEY ([[term_id]]) REFERENCES {{%term}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%term_relationships}}');
    }
}
