<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Update Profile Picture';
?>
<div class="user-profile-upload-profile-picture">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Current profile picture: <?= Html::img($model->image, ['alt' => 'profile picture', 'height' => 50]); ?></p>

    <div class="user-profile-form">

        <?php $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>

        <?= $form->field($model, 'image_file')->fileInput() ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-md-9">
                <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>