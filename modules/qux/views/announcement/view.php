<?php

use yii\helpers\Html;
use kartik\markdown\Markdown;
use yii\widgets\ListView;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Announcement */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="announcement-view">

    <div class="page-header">
        <h1><?= Html::encode($model->title) ?></h1>
        <p>
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?= Html::encode($model->user->full_name) ?>
            <span class="glyphicon glyphicon-calendar" aria-hidden="true"> </span> <?= Yii::$app->formatter->asDate($model->created_at, 'php:M d, Y g:i:s A') ?>
            <?php /*if (\Yii::$app->user->can('updatePost', ['post' => $model])): ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-xs btn-primary']) ?>
            <?php endif; ?>
            <?php// if (\Yii::$app->user->can('deletePost', ['post' => $model])): ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-xs btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?php endif; */?>
        </p>
    </div>

    <div class="body-content">
        <?= Markdown::convert($model->content) ?>
    </div>

    <div class="body-comments" id="comments">
        <div class="page-header">
            <h4>ALL COMMENTS</h4>
        </div>

        <div class="well well-sm">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_comments',
            ]); ?>
        </div>
    </div>

    <?php if (\Yii::$app->session->hasFlash('error_comment')): ?>
        <?=  Alert::widget([
            'options' => ['class' => 'alert-danger'],
            'body' => Yii::$app->session->getFlash('error_comment'),
        ]); ?>
    <?php endif; ?>
    <?= $this->render('_comment-form', [
        'model' => $comment,
    ]) ?>

</div>
