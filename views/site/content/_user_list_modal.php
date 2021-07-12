<?php

/* @var $this yii\web\View */
/* @var $model \app\models\GithubUser */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FAS;
use \yii\helpers\HtmlPurifier;

rmrevin\yii\fontawesome\AssetBundle::register($this);
?>

<h6>Добавить нового:</h6>

<?php $form = ActiveForm::begin(['id' => 'user_form']); ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::button('Сохранить', ['class' => 'btn btn-sm btn-success', 'id' => 'user_save_btn']) ?>
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Отмена</button>
    </div>

<?php ActiveForm::end(); ?>

<h6>Список существующих:</h6>

<div class="body-content">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            [
                'label' => 'username',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(HtmlPurifier::process($model->username), Url::to("https://github.com/". HtmlPurifier::process($model->username) . ""), ['target' => '_blank']);
                }
            ],
            [
                'label' => 'Действия',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(FAS::icon("trash"), null, [
                        'target' => '_blank',
                        'data-field' => HtmlPurifier::process($model->id),
                        'class' => 'user-delete',
                        'style' => 'cursor: pointer;'
                    ]);
                }
            ]
        ],
    ]); ?>
</div>