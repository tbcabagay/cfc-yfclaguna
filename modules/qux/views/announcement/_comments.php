<?php
use yii\helpers\Html;

?>

<div class="comment-section">
    <?= Html::img($model->user->profile_image, ['alt' => 'profile picture', 'height' => 60, 'style' => 'margin-right: 10px;', 'class' => 'pull-left']) ?>
    <p>
        <strong><?= Html::encode($model->user->full_name) ?></strong><br />
        <span class="text-muted"><em><?= Yii::$app->formatter->asDate($model->created_at, 'php:M d, Y g:i:s A') ?></em></span>
    </p>

    <p class="comment-content"><?= Html::encode($model->content) ?></p>
</div>