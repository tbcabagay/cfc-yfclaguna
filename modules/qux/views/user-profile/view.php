<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = 'View User';
$this->params['breadcrumbs'][] = ['label' => 'User Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'Member # ' . $model->id,
            'type'=>DetailView::TYPE_PRIMARY,
        ],
        'buttons1' => false,
        'buttons2' => false,
        'attributes' => [
            [
                'group' => true,
                'label' => 'Personal Information',
                'rowOptions' => ['class' => 'info']
            ],
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => Html::img($model->image, ['height' => 50]),
                'label' => false,
            ],
            'family_name',
            'given_name',
            'address',
            [
                'attribute' => 'birthday',
                'format'=>'date',
                'type'=>DetailView::INPUT_DATE,
                'widgetOptions' => [
                    'pluginOptions'=>['format'=>'yyyy-mm-dd']
                ],
            ],
            [
                'attribute' => 'joined_at',
                'format'=>'date',
                'type'=>DetailView::INPUT_DATE,
                'widgetOptions' => [
                    'pluginOptions'=>['format'=>'yyyy-mm-dd']
                ],
            ],
            'venue',
        ],
    ]) ?>

</div>
