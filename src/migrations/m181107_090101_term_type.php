<?php

namespace thienhungho\TermManagement\migrations;

use yii\db\Schema;

class m181107_090101_term_type extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%term_type}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(255)->notNull(),
            'slug'       => $this->string(255)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultValue(CURRENT_TIMESTAMP),
            'updated_at' => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'created_by' => $this->integer(19),
            'updated_by' => $this->integer(19),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%term_type}}');
    }
}
