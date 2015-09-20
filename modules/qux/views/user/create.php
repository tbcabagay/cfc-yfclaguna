<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use kartik\form\ActiveForm;


/* @var $this yii\web\View */
/* @var $user app\users\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

list(,$url)=Yii::$app->assetManager->publish('@vendor/kartik-v/dependent-dropdown');
$this->registerCssFile($url . '/css/dependent-dropdown.min.css');
$this->registerJsFile($url . '/js/dependent-dropdown.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$divisionLabel = Html::getInputId($model, 'division_label');
$divisionId = Html::getInputId($model, 'division_id');

$this->registerJs("
    $('#" . $divisionId . "').depdrop({
        url: '" . Url::to('/qux/user/division') . "',
        depends: ['" . $divisionLabel . "']
    });
", View::POS_END, 'dep-drop');
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
        ]); ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service_id')->dropDownList($service->getList(), ['prompt' => 'Select...']) ?>

        <?= $form->field($model, 'division_label')->dropDownList($model->getDivisionList(), ['prompt' => 'Select...']) ?>

        <?= $form->field($model, 'division_id')->dropDownList([], ['prompt' => 'Select...']) ?>

<?php /*
        <?= $form->field($model, 'role')->dropdownList($model->getRoleTypes()) ?>
*/ ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-md-9">
                <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
