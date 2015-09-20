<?php

use yii\helpers\Html;
use kartik\markdown\Markdown;
?>

<div class="page-header">
    <h2><?= Html::a(Html::encode($model->title), ['/qux/announcement/view', 'id' => $model->id]) ?></h2>
    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?= Html::encode($model->user->full_name) ?>
    <span class="glyphicon glyphicon-calendar" aria-hidden="true"> </span> <?= Yii::$app->formatter->asDate($model->created_at, 'php:M d, Y g:i:s A') ?>
</div>

<div class="body-content">
    <?= Markdown::convert($model->content) ?>
</div>

<p>
    <?= Html::a('View comments', ['/qux/announcement/view', 'id' => $model->id, '#' => 'comments'], ['class' => 'btn btn-success']) ?>
</p>