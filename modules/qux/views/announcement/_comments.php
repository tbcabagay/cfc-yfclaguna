<?php
use yii\helpers\Html;

?>

<div class="comment-section">
    <?= Html::img($model->user->userProfiles->image, ['alt' => 'profile picture', 'style' => 'margin-right: 10px;', 'class' => 'pull-left']) ?>
    <p>
        <strong><?= Html::encode($model->user->userProfiles->getFullName()) ?></strong>
        <small><?= Yii::$app->formatter->asDate($model->created_at, 'php:M d, Y g:i:s A') ?></small>
    </p>

    <p class="comment-content"><?= Html::encode($model->content) ?></p>
</div>