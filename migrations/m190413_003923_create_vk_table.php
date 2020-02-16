<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vk}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m190413_003923_create_vk_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vk}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'access_token' => $this->string()->null(),
            'name' => $this->string(),
            'lastname' => $this->string(),
            'avatar_link' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-vk-user_id}}',
            '{{%vk}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-vk-user_id}}',
            '{{%vk}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-vk-user_id}}',
            '{{%vk}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-vk-user_id}}',
            '{{%vk}}'
        );

        $this->dropTable('{{%vk}}');
    }
}
