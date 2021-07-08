<?php

namespace app\models\objects;

use Yii;
use yii\base\Model;

/**
 * Class GithubRepoList
 * @package app\models
 */
class GithubRepoList extends Model
{
    /**
     * @var array Список репозиториев
     */
    public $repositoryList;

    /**
     * GithubRepoList constructor.
     * @param array $repositoryList
     */
    public function __construct(array $repositoryList)
    {
        if (empty($repositoryList)) {
            $this->repositoryList = [];
        } else {
            foreach ($repositoryList as $repository) {
                $this->repositoryList[] = new GithubRepo($repository);
            }
        }
    }
}