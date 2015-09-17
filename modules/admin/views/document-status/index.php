<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Document Statuses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-status-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Document Status', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'document_id',
            'from_id',
            'from_label',
            'to_id',
            // 'to_label',
            // 'remarks',
            // 'received_by',
            // 'received_at',
            // 'released_by',
            // 'released_at',
            // 'action',
            // 'attachment',
            // 'time_difference:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
