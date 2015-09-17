<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\modules\qux\assets\QuxAsset;

QuxAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => [
            ['label' => 'Home', 'url' => ['/qux/default/index']],
            ['label' => 'Announcements', 'url' => ['/qux/announcement/index']],
            ['label' => 'Documents', 'items' => [
                ['label' => 'My Documents', 'url' => ['/qux/document/index']],
                ['label' => 'Receive', 'url' => ['/qux/document-status/receive']],
                ['label' => 'Release', 'url' => ['/qux/document-status/release']],
            ]],
            ['label' => 'Users', 'url' => ['/qux/user/index']],
            ['label' => 'Divisions', 'items' => [
                ['label' => 'Provincial', 'url' => ['/qux/provincial/index']],
                ['label' => 'Sector', 'url' => ['/qux/sector/index']],
                ['label' => 'Cluster', 'url' => ['/qux/cluster/index']],
                ['label' => 'Chapter', 'url' => ['/qux/chapter/index']],
            ]],
            ['label' => 'Services', 'url' => ['/qux/service/index']],
            ['label' => Html::img(\Yii::$app->session->get('userProfile.url'), ['alt' => 'profile picture', 'style' => 'width: 20px; height: 20px; margin-right: 8px;']) . \Yii::$app->session->get('userProfile.name'), 'items' => [
                    [
                        'label' => 'Profile',
                        //'url' => ['/qux/user/profile', 'id' => \Yii::$app->user->identity->id],
                    ],
                    [
                        'label' => 'Logout',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                    ],
                ],
            ],
                        
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
