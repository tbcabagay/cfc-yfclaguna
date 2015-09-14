<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
        ]); ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'role')->dropdownList($model->getRoleTypes()) ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-md-9">
                <?= Html::submitButton('Register', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
