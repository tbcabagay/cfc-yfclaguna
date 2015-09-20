<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Update User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

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
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
        ]); ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service_id')->dropDownList($service->getList(), ['prompt' => 'Select...'], ['options' => [$model->service_id => ['selected' => true]]]) ?>

        <?= $form->field($model, 'division_label')->dropDownList($model->getDivisionList(), ['prompt' => 'Select...'], ['options' => [$model->division_label => ['selected' => true]]]) ?>

        <?= $form->field($model, 'division_id')->dropDownList([], ['prompt' => 'Select...'], ['options' => [$model->division_id => ['selected' => true]]]) ?>

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