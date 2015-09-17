<?php

use yii\helpers\Html;
use kartik\helpers\Enum;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentStatus */

$this->title = 'Document Trail';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-status-view">

    <div class="well well-lg">
        <div class="page-header">
            <h2 class="text-success"><?= Html::encode($model->title) ?></h2>
        </div>

        <dl class="dl-horizontal">            
            <dt>Author</dt>
            <dd><?= Html::encode($model->user->userProfiles->getFullName()) ?></dd>
            <dt>Area</dt>
            <dd><?= Html::encode($model->user->division) ?></dd>
            <dt>Original Attachment</dt>
            <dd><?= Html::a('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['qux/document/download', 'id' => $model->id]) ?></dd>
            <dt>Status</dt>
            <dd><?= $model->getStatus($model->status) ?></dd>
            <dt>Created At</dt>
            <dd><?= Yii::$app->formatter->asDatetime($model->created_at, 'php:M d, Y g:i:s A'); ?></dd>
        </dl>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'from',
                'value' => 'from',
                'label' => 'From',
            ],
            [
                'attribute' => 'to',
                'value' => 'to',
                'label' => 'To',
            ],
            [
                'attribute' => 'attachment',
                'value' => function($model, $key, $index, $column) {
                    return ($model->attachment === null) ? $model->attachment : Html::a('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['download', 'id' => $model->id], ['class' => 'text-center']);
                },
                'filter' => false,
                'format' => 'html',
            ],
            [
                'attribute' => 'action',
                'value' => function($model, $key, $index, $column) {
                    return $model->getAction($model->action);
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'remarks',
                'value' => 'remarks',
            ],
            [
                'attribute' => 'received_at',
                'value' => function($model, $key, $index, $column) {
                    return Yii::$app->formatter->asDatetime($model->received_at, 'php:M d, Y g:i:s A');
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'released_at',
                'value' => function($model, $key, $index, $column) {
                    return Yii::$app->formatter->asDatetime($model->released_at, 'php:M d, Y g:i:s A');
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'time_difference',
                'value' => function($model, $key, $index, $column) {
                    if (($model->received_at !== null) && ($model->released_at !== null))
                        return '<span class="label label-danger">' . $model->dateDiff($model->received_at, 2, $model->released_at) . '</span>';
                    else
                        return null;
                },
                'format' => 'html',
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-folder-open"></span> Documents Trail',
        ],
        'condensed' => true,
        'hover' => true,
        'toolbar'=> false,
    ]); ?>

</div>