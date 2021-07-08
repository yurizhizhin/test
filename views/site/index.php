<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $model \app\models\GithubUser */

use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Github repo list';
?>

<h1>Список репозиториев</h1>

<p>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#new_user_model">
        Добавить нового пользователя
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
                        return Html::a($model->user->username, Url::to("https://github.com/{$model->user->username}"), ['target' => '_blank']);
                    }
                ],
                [
                    'label' => 'Название',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a($model->repo_name, Url::to("https://github.com/{$model->repo_name}"), ['target' => '_blank']);
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

<div class="modal fade" tabindex="-1" role="dialog" id="new_user_model">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Новый пользователь</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>