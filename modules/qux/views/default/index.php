<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'Welcome';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-default-index">
    <div class="page-header">
        <h1>Latest News</h1>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_news',
    ]); ?>
</div>
