<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Services';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-list-alt"></span> Services',
        ],
        'condensed' => true,
        'hover' => true,
        'toolbar'=> [
            [
                'content' => Html::a('<span class="glyphicon glyphicon-plus"></span> Create Service', ['create'], ['class' => 'btn btn-success', 'title' => 'Create Sector'])
            ],
        ],
    ]); ?>

</div>
