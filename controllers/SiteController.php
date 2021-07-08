<?php

namespace app\controllers;

use app\components\github\GithubComponent;
use app\models\GithubUser;
use app\models\search\GithubRepoSearch;
use Yii;
use yii\web\Controller;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;

        $searchModel = new GithubRepoSearch();
        $dataProvider = $searchModel->search();

        $model = new GithubUser();

        if ($model->load($request->post())) {
            try {
                if (GithubComponent::getUser($model->username) && $model->save()) {
                    GithubComponent::fetchUserRepoList($model->username);

                    Yii::$app->session->addFlash('success', "Пользователь {$model->username} был успешно добавлен");
                } else {
                    Yii::$app->session->addFlash('error', 'Указанный пользователь не существует в github или уже был добавлен');
                }
            } catch (\Throwable $ex) {
                Yii::$app->session->addFlash('error', "Что - то пошло не так, попробуйте позже {$ex->getMessage()}");
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => new GithubUser()
        ]);
    }
}
