<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProvincialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Provincials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provincial-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'label',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-globe"></span> Provincials',
        ],
        'condensed' => true,
        'hover' => true,
        'toolbar'=> [
            [
                'content' => Html::a('<span class="glyphicon glyphicon-plus"></span> Create Provincial', ['create'], ['class' => 'btn btn-success', 'title' => 'Create Provincial'])
            ],
        ],
    ]); ?>

</div>
