<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%github_repo}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $repo_name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property GithubUser $user
 */
class GithubRepo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%github_repo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'repo_name', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['repo_name'], 'string', 'max' => 255],
            [['repo_name'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => GithubUser::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'repo_name' => 'Название',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(GithubUser::class, ['id' => 'user_id']);
    }
}
