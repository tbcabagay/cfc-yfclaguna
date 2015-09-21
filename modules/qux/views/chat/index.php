<?php

$this->title = 'Chat';
?>

<div class="container">
<?= \sintret\chat\ChatRoom::widget([
    'url' => \yii\helpers\Url::to(['/qux/chat/send-chat']),
    'userModel' =>  \app\models\User::className(),
    'userField' =>'image'
]); ?>
</div>