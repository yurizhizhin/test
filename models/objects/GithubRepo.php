<?php

namespace app\models\objects;

use Yii;
use yii\base\Model;

/**
 * Class GithubRepo
 * @package app\models
 */
class GithubRepo extends Model
{
    public $repo_name;

    public $ownerName;

    public $created_at;

    public $updated_at;

    public function __construct(array $repositoryInfo)
    {
        $this->repo_name = $repositoryInfo['full_name'];
        $this->ownerName = $repositoryInfo['owner']['login'];
        $this->created_at = $repositoryInfo['created_at'];
        $this->updated_at = $repositoryInfo['updated_at'];
    }
}