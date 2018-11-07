<?php

namespace thienhungho\TermManagement\migrations;

use yii\db\Schema;

class m181107_090101_term extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%term}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'author' => $this->integer(19),
            'feature_img' => $this->string(255),
            'term_parent' => $this->integer(19),
            'term_type' => $this->string(255),
            'language' => $this->string(255),
            'assign_with' => $this->integer(19),
            'created_at' => $this->timestamp()->notNull()->defaultValue(CURRENT_TIMESTAMP),
            'updated_at' => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'created_by' => $this->integer(19),
            'updated_by' => $this->integer(19),
            'FOREIGN KEY ([[author]]) REFERENCES {{%user}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[term_type]]) REFERENCES {{%term_type}} ([[name]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
                
    }

    public function safeDown()
    {
        $this->dropTable('{{%term}}');
    }
}
