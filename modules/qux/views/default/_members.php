<?php

use yii\helpers\Html;
?>


<div class="pull-left">
    <?= Html::img($model->image, ['height' => 50]) ?>
</div>
<div class="search-data">
    <address>
        <strong><?= Html::encode($model->user->full_name) ?></strong> <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> View', ['/qux/user-profile/view', 'id' => $model->user->id], ['class' => 'btn btn-primary btn-xs']) ?><br />
        <?= Yii::$app->formatter->asEmail($model->user->email) ?><br />
        <?= Html::encode($model->user->service->name) ?>
    </address>
</div>