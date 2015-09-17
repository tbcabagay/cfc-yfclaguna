<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Receive Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-status-index">

    <?= Html::beginForm(['document-status/bulk-receive'], 'post');?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['class' => 'yii\grid\CheckboxColumn'],

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
                    'template' => '{view}',
                ],
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-folder-open"></span> Receive Documents',
            ],
            'condensed' => true,
            'hover' => true,
            'toolbar'=> [
            [
                'content' => Html::submitButton('<span class="glyphicon glyphicon-plus"></span> Receive', ['class' => 'btn btn-success', 'title' => 'Receive'])
            ],
        ],
        ]); ?>

    <?= Html::endForm();?>

</div>
