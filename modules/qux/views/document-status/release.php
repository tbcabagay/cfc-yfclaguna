<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Release Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-status-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'value' => 'from',
                'label' => 'From',
            ],
            [
                'value' => 'document.title',
                'label' => 'Title'
            ],
            [
                'value' => 'document.remarks',
                'label' => 'Remarks'
            ],
            [
                'value' => function($model, $key, $index, $column) {
                    return Yii::$app->formatter->asDatetime($model->document->created_at, 'php:M d, Y g:i:s A');
                },
                'label' => 'Date Created'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {release}',
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/qux/document/view', 'id' => $model->document_id], [
                            'title' => 'View',
                            'aria-label' => 'View',
                            'data-pjax' => 0,
                        ]);
                    },
                    'release' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-export"></span>', ['/qux/document-status/do-release', 'id' => $model->id], [
                            'title' => 'Export',
                            'aria-label' => 'Export',
                            'data-pjax' => 0,
                        ]);
                    },
                ],
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-folder-open"></span> Release Documents',
        ],
        'condensed' => true,
        'hover' => true,
        'toolbar' => false,
    ]); ?>


</div>
