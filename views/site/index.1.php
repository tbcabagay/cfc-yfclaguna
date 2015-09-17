<?php

/* @var $this yii\web\View */

use dosamigos\gallery\Gallery;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;

$this->title = Yii::$app->params['appOwner'];
?>

<section class="module parallax parallax-1">
    <div class="container">

    <div class="user-menu">
        <ul class="list-inline">
            <li><?= Html::a('Register', ['register'], ['class' => 'btn btn-warning']) ?></li>
            <li><?= Html::a('Login', ['login'], ['class' => 'btn btn-warning']) ?></li>
        </ul>
    </div>

        <h1>Couples for Christ <br /><small>Youth for Christ</small></h1>

        <?php if (\Yii::$app->user->isGuest): ?>
            <p class="sign-in"><?= Html::a(FA::icon('google') . ' Sign-in', ['site/auth', 'authclient' => 'google'], ['class' => 'btn btn-lg btn-danger']) ?></p>
        <?php else: ?>
            <p class="sign-in"><?= Html::a(FA::icon('sign-in') . ' Go to app', ['/qux/default/index'], ['class' => 'btn btn-lg btn-primary']) ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="module content">
    <div class="container">
        <h2>Mission</h2>
        <p>Building the church for the home, building the church for the poor.</p>
        <h2>Vision</h2>
        <p>Young people bringing and being Christ wherever they are.</p>
    </div>
</section>

<section class="module parallax parallax-2">
</section>

<section class="module content">
    <div class="container">
        <h2>Events Gallery</h2>

        <?= Gallery::widget([
            'items' => [
                [
                    'url' => ['@web/images/carousel/1.jpg'],
                    'src' => ['@web/images/carousel/1_thumb.jpg'],
                ],
                [
                    'url' => ['@web/images/carousel/2.jpg'],
                    'src' => ['@web/images/carousel/2_thumb.jpg'],
                ],
                [
                    'url' => ['@web/images/carousel/3.jpg'],
                    'src' => ['@web/images/carousel/3_thumb.jpg'],
                ],
                [
                    'url' => ['@web/images/carousel/4.jpg'],
                    'src' => ['@web/images/carousel/4_thumb.jpg'],
                ],
                [
                    'url' => ['@web/images/carousel/5.jpg'],
                    'src' => ['@web/images/carousel/5_thumb.jpg'],
                ],
                [
                    'url' => ['@web/images/carousel/6.jpg'],
                    'src' => ['@web/images/carousel/6_thumb.jpg'],
                ],
                [
                    'url' => ['@web/images/carousel/7.jpg'],
                    'src' => ['@web/images/carousel/7_thumb.jpg'],
                ],
            ],
        ]); ?>
    </div>
</section>

<section class="module parallax parallax-3">
</section>

<section class="module content footer">
    <div class="container">
        <p><?= \Yii::$app->params['appName'] ?><br />
        &copy; <?= \Yii::$app->params['appOwner'] ?> <?= date('Y') ?></p>
    </div>
</section>