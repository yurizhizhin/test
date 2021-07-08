<?php

use yii\db\Migration;

/**
 * Class m210628_083956_create_github_repo
 */
class m210628_083956_create_github_repo extends Migration
{
    /**
     * @var string
     */
    const TABLE_NAME = '{{%github_repo}}';

    /**
     * @var string
     */
    const REF_TABLE_USER = '{{%github_user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'repo_name' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('fk_github-repo_user_id', self::TABLE_NAME, 'user_id',
            self::REF_TABLE_USER, 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('unique_github_repo', self::TABLE_NAME, 'repo_name', $unique = true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_github-repo_user_id', self::TABLE_NAME);

        $this->dropIndex('unique_github_repo', self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
