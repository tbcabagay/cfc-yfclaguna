<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'document_id')->textInput() ?>

    <?= $form->field($model, 'from_id')->textInput() ?>

    <?= $form->field($model, 'from_label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_id')->textInput() ?>

    <?= $form->field($model, 'to_label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'received_by')->textInput() ?>

    <?= $form->field($model, 'received_at')->textInput() ?>

    <?= $form->field($model, 'released_by')->textInput() ?>

    <?= $form->field($model, 'released_at')->textInput() ?>

    <?= $form->field($model, 'action')->textInput() ?>

    <?= $form->field($model, 'attachment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_difference')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
