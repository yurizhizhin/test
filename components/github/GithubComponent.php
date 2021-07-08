<?php

namespace app\components\github;

use app\models\GithubRepo;
use app\models\GithubUser;
use app\models\objects\GithubRepoList;
use Github\Exception\RuntimeException;
use Github\HttpClient\Builder;
use Yii;
use app\components\github\interfaces\GithubComponentInterface;
use Github\Client;
use yii\db\Exception;

/**
 * Class GithubComponent
 * @package app\components\github
 */
class GithubComponent implements GithubComponentInterface
{
    /**
     * @param string $username
     * @return void
     */
    public static function fetchUserRepoList(string $username, int $userID = null): void
    {
        $client = self::authorize();

        $repoFetchResult = $client->api(self::DEFAULT_API_NAME)
            ->repositories($username, 'all', $page = 1, self::CRITERIA_UPDATED_AT);

        if (!$userID) {
            $githubUser = GithubUser::findOne(['username' => $username]);

            $userID = $githubUser->id;
        }

        $repoList = new GithubRepoList($repoFetchResult);

        foreach ($repoList->repositoryList as $repo) {
            $model = new GithubRepo();

            $model->user_id = $userID;
            $model->repo_name = $repo->repo_name;
            $model->created_at = strtotime($repo->created_at);
            $model->updated_at = strtotime($repo->updated_at);

            $model->save();
        }
    }

    /**
     * Clean repo table and fill with actual data of users' repos
     *
     * @throws \Throwable
     */
    public static function actualizeRepoListRoutine(): void
    {
        $db = Yii::$app->db;

        $db->createCommand("TRUNCATE TABLE " . GithubRepo::tableName())->execute();

        $userList = GithubUser::find()->all();

        foreach ($userList as $user) {
            self::fetchUserRepoList($user->username, $user->id);
        }
    }

    /**
     * @param string $username
     * @return bool
     * @throws \Exception
     */
    public static function getUser(string $username): bool
    {
        $client = self::authorize();

        try {
            $user = $client->user()->show($username);
        } catch (RuntimeException $ex) {
            if ($ex->getMessage() == self::ERROR_NOT_FOUND) {
                return false;
            } else {
                throw new \Exception($ex->getMessage());
            }
        }

        return true;
    }

    /**
     * @return Client
     */
    private static function authorize(): Client
    {
        $githubSecret = Yii::$app->params['github_token'];

        $client = new Client(new Builder());
        $client->authenticate($githubSecret, null, Client::AUTH_CLIENT_ID);

        return $client;
    }
}