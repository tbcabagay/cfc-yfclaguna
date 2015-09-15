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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cluster', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sector_id',
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
