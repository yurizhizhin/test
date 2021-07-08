<?php

use yii\db\Migration;

/**
 * Class m210627_140756_create_github_user
 */
class m210627_140756_create_github_user extends Migration
{
    /**
     * @var string
     */
    const TABLE_NAME = '{{%github_user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'username' => $this->string(32)->notNull(),
        ]);

        $this->createIndex('unique_github-user_username', self::TABLE_NAME, ['username'], $unique = true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('unique_github-user_username', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
