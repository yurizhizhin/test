<?php

namespace app\controllers;

use app\components\github\GithubComponent;
use app\models\GithubUser;
use app\models\search\GithubRepoSearch;
use app\models\search\GithubUserSearch;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
        $searchModel = new GithubRepoSearch();
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays list of github users
     *
     * @return string
     * @throws \Throwable
     */
    public function actionUserList()
    {
        $request = Yii::$app->request;

        if (!$request->isAjax) {
            throw new NotFoundHttpException();
        }

        $searchModel = new GithubUserSearch();
        $dataProvider = $searchModel->search($request->post());

        return $this->renderAjax('//site/content/_user_list_modal', [
            'dataProvider' => $dataProvider,
            'model' => new GithubUser()
        ]);
    }

    /**
     * Creates user (ajax only)
     *
     * @return string
     * @throws \Throwable
     */
    public function actionCreateUser()
    {
        $request = Yii::$app->request;

        if (!$request->isAjax) {
            throw new NotFoundHttpException();
        }

        $model = new GithubUser();

        if ($model->load($request->post())) {
            try {
                if (GithubComponent::getUser($model->username) && $model->save()) {
                    GithubComponent::fetchUserRepoList($model->username);

                    $result = [
                        'success' => true,
                        'message' => "Пользователь {$model->username} был успешно добавлен"
                    ];

                    Yii::$app->session->addFlash('success', "Пользователь {$model->username} был успешно добавлен");
                } else {
                    $result = [
                        'success' => false,
                        'message' => 'Пользователь не найден'
                    ];
                }
            } catch (\Throwable $ex) {
                $result = [
                    'success' => false,
                    'message' => "Что - то пошло не так, попробуйте позже {$ex->getMessage()}",
                ];
            }
        }

        return Json::encode($result);
    }

    /**
     * Deletes user (ajax only)
     *
     * @return string
     * @throws \Throwable
     */
    public function actionDeleteUser()
    {
        $request = Yii::$app->request;

        if (!$request->isAjax) {
            throw new NotFoundHttpException();
        }

        $userID = $request->post('userID');

        $model = (!is_null($userID) ? GithubUser::getUser($userID) : null);

        if ($model && $model->delete()) {
            $result = [
                'success' => true,
                'message' => "Пользователь {$model->username} был удален"
            ];

            Yii::$app->session->addFlash('success', "Пользователь {$model->username} был удален");
        } else {
            $result = [
                'success' => false,
                'message' => 'Пользователь не найден'
            ];
        }

        return Json::encode($result);
    }
}
