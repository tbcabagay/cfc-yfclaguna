<?php

use dosamigos\gallery\Gallery;
use yii\helpers\Html;

$this->title = 'Home';
?>

<section class="module content header">
    <div class="container">
        <h1><?= \Yii::$app->params['appName'] ?></h1>
        <p><?= \Yii::$app->params['appOwner'] ?></p>
    </div>
</section>

<section class="module content center">
    <div class="container">
        <h2>Mission</h2>
        <p>Building the church for the home, building the church for the poor.</p>
        <h2>Vision</h2>
        <p>Young people bringing and being Christ wherever they are.</p>
  </div>
</section>

<section class="module parallax parallax-1">
    <div class="container">
    </div>
</section>

<section class="module content center">
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