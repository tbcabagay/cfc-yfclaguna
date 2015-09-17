<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentStatusSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-status-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'document_id') ?>

    <?= $form->field($model, 'from_id') ?>

    <?= $form->field($model, 'from_label') ?>

    <?= $form->field($model, 'to_id') ?>

    <?php // echo $form->field($model, 'to_label') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'received_by') ?>

    <?php // echo $form->field($model, 'received_at') ?>

    <?php // echo $form->field($model, 'released_by') ?>

    <?php // echo $form->field($model, 'released_at') ?>

    <?php // echo $form->field($model, 'action') ?>

    <?php // echo $form->field($model, 'attachment') ?>

    <?php // echo $form->field($model, 'time_difference') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
