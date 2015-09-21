<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'Search Results';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-default-index">
    <div class="page-header">
        <h1>Search Results</h1>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_members',
    ]); ?>
</div>
