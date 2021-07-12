<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $model \app\models\GithubUser */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;

$this->title = 'Github repo list';
?>

<h1>Список репозиториев</h1>

<p>
    <button type="button" id="user_list_modal_btn" class="btn btn-success" data-toggle="modal" data-target="#user_list_modal">
        Список пользователей
    </button>
</p>

<div class="site-index">
    <div class="body-content">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '',
            'columns' => [
                [
                    'label' => 'Пользователь',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a(HtmlPurifier::process($model->user->username), Url::to("https://github.com/" . HtmlPurifier::process($model->user->username) . ""), ['target' => '_blank']);
                    }
                ],
                [
                    'label' => 'Название',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a(HtmlPurifier::process(HtmlPurifier::process($model->repo_name)), Url::to("https://github.com/". HtmlPurifier::process($model->repo_name)), ['target' => '_blank']);
                    }
                ],
                [
                    'label' => 'Последнее изменение репозитория',
                    'value' => function ($model) {
                        return date('Y-m-d H:i:s', $model->updated_at);
                    }
                ],
            ],
        ]); ?>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="user_list_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Список пользователей</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="alert"></div>
            <div class="modal-body" id="user_list_content">
                <!-- Ajax content -->
            </div>
        </div>
    </div>
</div>

<?php

$this->registerJsFile(
    Url::to(['/js/main.js']),
    [
        'depends' => \yii\web\JqueryAsset::class
    ]
);