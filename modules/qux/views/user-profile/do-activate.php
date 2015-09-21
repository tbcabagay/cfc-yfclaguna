<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Activate User';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-profile-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
        ]); ?>

    <?= $form->field($model, 'joined_at')->widget(DatePicker::classname(), [
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
        ],
    ]); ?>

    <?= $form->field($model, 'venue')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-md-9">
            <?= Html::submitButton('Activate', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
