<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'service_id',
                'value' => 'service.name',
                'filter' => Html::activeDropDownList($searchModel, 'service_id', $service->getList(), ['class'=>'form-control','prompt' => '']),
            ],
            'email:email',
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->getStatusTypes(), ['class'=>'form-control','prompt' => '']),
                'value' => function($model, $index, $widget) {
                    return $model->filterStatus($model->status);
                },
            ],
            'role',
            [
                'attribute' => 'created_at',
                'value' => 'created_at',
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ],
                ],
            ],
            [
                'attribute' => 'updated_at',
                'value' => 'updated_at',
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ],
                ],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-user"></span> Users',
        ],
        'condensed' => true,
        'hover' => true,
        'toolbar'=> [
            [
                'content' => Html::a('<span class="glyphicon glyphicon-plus"></span> Create User', ['create'], ['class' => 'btn btn-success', 'title' => 'Create User'])
            ],
        ],
    ]); ?>

</div>
