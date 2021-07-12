<?php

use yii\db\Migration;

/**
 * Class m210712_134047_alter_github_repo
 */
class m210712_134047_alter_github_repo extends Migration
{
    /**
     * @var string
     */
    const TABLE_NAME = '{{%github_repo}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('unique_github_repo', self::TABLE_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createIndex('unique_github_repo', self::TABLE_NAME, 'repo_name', $unique = true);
    }
}
