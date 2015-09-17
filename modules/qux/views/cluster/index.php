<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClusterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clusters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cluster-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'sector_id',
                'value' => 'sector.label',
                'filter' => Html::activeDropDownList($searchModel, 'sector_id', $searchModel->getSectorList(), ['class'=>'form-control','prompt' => '']),
            ],
            'label',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-globe"></span> Clusters',
        ],
        'condensed' => true,
        'hover' => true,
        'toolbar'=> [
            [
                'content' => Html::a('<span class="glyphicon glyphicon-plus"></span> Create Cluster', ['create'], ['class' => 'btn btn-success', 'title' => 'Create Cluster'])
            ],
        ],
    ]); ?>

</div>
