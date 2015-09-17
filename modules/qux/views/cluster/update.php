<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cluster */

$this->title = 'Update Cluster';
$this->params['breadcrumbs'][] = ['label' => 'Clusters', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cluster-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
