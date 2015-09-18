<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Members';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'service_id',
                'value' => 'service.name',
                'filter' => Html::activeDropDownList($searchModel, 'service_id', $searchModel->getServiceList(), ['class'=>'form-control','prompt' => '']),
            ],
            [
                'attribute' => 'cluster_id',
                'value' => 'cluster.label',
                'filter' => Html::activeDropDownList($searchModel, 'cluster_id', $searchModel->getClusterList(), ['class'=>'form-control','prompt' => '']),
            ],
            'username',
            'family_name',
            'given_name',
            'email:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-user"></span> Members',
        ],
        'condensed' => true,
        'hover' => true,
        'toolbar'=> [
            [
                'content' => Html::a('<span class="glyphicon glyphicon-plus"></span> Create Member', ['create'], ['class' => 'btn btn-success', 'title' => 'Create Provincial'])
            ],
        ],
    ]); ?>

</div>
