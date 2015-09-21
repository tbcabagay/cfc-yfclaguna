<?php

use yii\helpers\Html;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Announcement */

$this->title = 'Update Announcement';
$this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="announcement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (\Yii::$app->session->hasFlash('update-error')): ?>
        <?= Alert::widget([
            'options' => ['class' => 'alert-danger'],
            'body' => \Yii::$app->session->getFlash('update-error'),
        ]); ?>    
    <?php endif; ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
