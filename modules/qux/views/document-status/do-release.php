<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentStatus */

$this->title = 'Release Document';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-status-do-release">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="well well-sm">
        <dl class="dl-horizontal">
            <dt>Author</dt>
            <dd><?= Html::encode($model->document->user->userProfiles->getFullName()) ?></dd>
            <dt>Area</dt>
            <dd><?= Html::encode($model->document->user->division) ?></dd>
            <dt>Title</dt>
            <dd><?= Html::encode($model->document->title) ?></dd>
        </dl>
    </div>

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'remarks')->textArea(['maxlength' => true]) ?>

    <?= $form->field($model, 'action')->dropDownList($model->getActionTypes(), ['prompt' => 'Select...']) ?>

    <?= $form->field($model, 'attachment_file')->fileInput() ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-md-9">
            <?= Html::submitButton('Release', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
