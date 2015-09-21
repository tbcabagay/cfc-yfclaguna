<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;

$this->title = 'Member Registration';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (\Yii::$app->session->hasFlash('contact-success')): ?>
    <?= Alert::widget([
        'options' => ['class' => 'alert-success'],
        'body' => \Yii::$app->session->getFlash('contact-success'),
    ]); ?>    
<?php endif; ?>

<div class="user-profile-form">
    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
    ]); ?>
    
    <fieldset>
        <legend>Account Information</legend>

        <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($user, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($user, 'confirm_password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($user, 'service_id')->dropDownList($service->getList(), ['prompt' => 'Select...']) ?>

        <?= $form->field($user, 'cluster_id')->dropDownList($cluster->getList(), ['prompt' => 'Select...']) ?>

        <?= $form->field($user, 'role')->dropdownList(ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'name'), ['prompt' => 'Select...']) ?>
    </fieldset>

    <fieldset>
        <legend>Personal Information</legend>

        <?= $form->field($userProfile, 'family_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($userProfile, 'given_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($userProfile, 'address')->textArea(['maxlength' => true]) ?>

        <?= $form->field($userProfile, 'contact_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($userProfile, 'birthday')->widget(DatePicker::classname(), [
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
            ],
        ]) ?>

        <?= $form->field($userProfile, 'joined_at')->widget(DatePicker::classname(), [
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
            ],
        ]) ?>

        <?= $form->field($userProfile, 'venue')->textInput(['maxlength' => true]) ?>
    </fieldset>

    <div class="form-group">
        <div class="col-sm-offset-2 col-md-9">
            <?= Html::submitButton('Register', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>