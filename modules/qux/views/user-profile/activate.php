<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Activate Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-status-index">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'family_name',
                'given_name',
                [
                    'attribute' => 'email',
                    'format' => 'email',
                    'value' => function($model, $key, $index, $column) {
                        return $model->user->email;
                    },
                ],
                [
                    'attribute' => 'user.service_id',
                    'value' => 'user.service.name',
                ],
                [
                    'attribute' => 'user.cluster_id',
                    'value' => function($model, $key, $index, $column) {
                        return $model->user->cluster;
                    },
                ],
                
                [
                    'value' => function($model, $key, $index, $column) {
                        return Yii::$app->formatter->asDatetime($model->user->created_at, 'php:M d, Y g:i:s A');
                    },
                    'label' => 'Date Created'
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {release}',
                    'buttons' => [
                        'view' => function($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/qux/user-profile/view', 'id' => $model->user_id], [
                                'title' => 'View',
                                'aria-label' => 'View',
                                'data-pjax' => 0,
                            ]);
                        },
                        'release' => function($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', ['/qux/user-profile/do-activate', 'id' => $model->user_id], [
                                'title' => 'Activate',
                                'aria-label' => 'Activate',
                                'data-pjax' => 0,
                            ]);
                        },
                    ],
                ],
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-user"></span> Activate Users',
            ],
            'condensed' => true,
            'hover' => true,
            'toolbar'=> [
                [
                    'content' => Html::submitButton('<span class="glyphicon glyphicon-plus"></span> Activate', ['class' => 'btn btn-success', 'title' => 'Activate'])
                ],
            ],
        ]); ?>

</div>