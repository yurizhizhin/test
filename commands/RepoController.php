<?php

namespace app\commands;

use Yii;
use app\components\github\GithubComponent;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class RepoController
 * @package app\commands
 */
class RepoController extends Controller
{
    /**
     * @return int
     */
    public function actionUpdate()
    {
        try {
            GithubComponent::actualizeRepoListRoutine();

            echo "Update OK \n";

            return ExitCode::OK;
        } catch (\Throwable $ex) {
            echo "Something went wrong, check logs \n";

            self::log($ex);

            return ExitCode::DATAERR;
        }
    }

    /**
     * @param \Throwable $ex
     */
    private static function log(\Throwable $ex)
    {
        $oldTraceLevel = Yii::$app->log->traceLevel;
        Yii::$app->log->traceLevel = 0;

        Yii::error($ex->getMessage() . "\n" . $ex->getTraceAsString() . "\n", 'console-error');

        Yii::$app->log->traceLevel = $oldTraceLevel;
    }
}
