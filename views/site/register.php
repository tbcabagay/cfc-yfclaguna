<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;

$this->title = 'Registration';
?>

<section class="module content header">
    <div class="container">
        <h1>Register</h1>
    </div>
</section>

<section class="module content">
    <div class="container">
        <?php if (\Yii::$app->session->hasFlash('contact-success')): ?>
        <?= Alert::widget([
            'options' => ['class' => 'alert-success'],
            'body' => \Yii::$app->session->getFlash('contact-success'),
        ]); ?>    
        <?php endif; ?>

        <div class="member-form">
            <div class="col-md-10">
                <?php $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                ]); ?>


                <fieldset>
                    <legend>Account Information</legend>

                    <?= $form->field($member, 'username')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($member, 'password')->passwordInput(['maxlength' => true]) ?>

                    <?= $form->field($member, 'confirm_password')->passwordInput(['maxlength' => true]) ?>

                    <?= $form->field($member, 'service_id')->dropDownList($service->getList(), ['prompt' => 'Select...']) ?>

                    <?= $form->field($member, 'cluster_id')->dropDownList($cluster->getList(), ['prompt' => 'Select...']) ?>
                </fieldset>

                <fieldset>
                    <legend>Personal Information</legend>

                    <?= $form->field($member, 'family_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($member, 'given_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($member, 'address')->textArea(['maxlength' => true]) ?>

                    <?= $form->field($member, 'email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($member, 'birthday')->widget(DatePicker::classname(), [
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                        ],
                    ]); ?>
                </fieldset>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-md-9">
                        <?= Html::submitButton('Register', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
  </div>
</section>
