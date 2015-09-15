<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Provincial */

$this->title = 'Create Provincial';
$this->params['breadcrumbs'][] = ['label' => 'Provincials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provincial-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
