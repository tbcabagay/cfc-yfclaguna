<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'user_id',
                'value' => function($model, $key, $index, $column) {
                    return $model->user->full_name;
                },
                'filter' => false,
                'label' => 'User',
            ],
            [
                'attribute' => 'attachment',
                'value' => function($model, $key, $index, $column) {
                    return Html::a('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['download', 'id' => $model->id], ['class' => 'text-center']);
                },
                'filter' => false,
                'format' => 'html',
            ],
            'title',
            'remarks',
            /*[
                'attribute' => 'status',
                'value' => function($model, $key, $index, $column) {
                    return $model->
                },
            ],*/
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
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/qux/document-status/view', 'id' => $model->id], [
                            'title' => 'View',
                            'aria-label' => 'View',
                            'data-pjax' => 0,
                        ]);
                    },
                ],
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-folder-open"></span> Documents',
        ],
        'condensed' => true,
        'hover' => true,
        'toolbar'=> [
            [
                'content' => Html::a('<span class="glyphicon glyphicon-plus"></span> Create Document', ['create'], ['class' => 'btn btn-success', 'title' => 'Create Provincial'])
            ],
        ],
    ]); ?>

</div>
