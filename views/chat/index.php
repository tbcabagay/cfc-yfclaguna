<?php

use kartik\icons\Icon;
Icon::map($this);

$this->title = 'Chat';
?>

<div class="container">
<?= \sintret\chat\ChatRoom::widget([
    'url' => \yii\helpers\Url::to(['/chat/send-chat']),
    'userModel' =>  \app\models\User::className(),
    'userField' =>'image'
]); ?>
</div>