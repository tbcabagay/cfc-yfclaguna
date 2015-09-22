<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\modules\qux\assets\QuxAsset;
use kartik\widgets\TypeaheadBasic;
use kartik\icons\Icon;

QuxAsset::register($this);
Icon::map($this);
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
<?php
$data = [];
$given_name = \yii\helpers\ArrayHelper::getColumn(\app\models\UserProfile::find()->select('given_name')->all(), 'given_name');
$family_name = \yii\helpers\ArrayHelper::getColumn(\app\models\UserProfile::find()->select('family_name')->all(), 'family_name');

if (!empty($given_name) || !empty($family_name))
    $data = array_merge($given_name, $family_name);
else
    $data = ['No Data'];
?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->params['appOwner'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => [
            ['label' => '<i class="fa fa-home"></i> Home', 'url' => ['/qux/default/index']],
            ['label' => '<i class="fa fa-comments"></i> Chat', 'url' => ['/qux/chat/index']],
            ['label' => '<i class="fa fa-bullhorn"></i> Announcements', 'visible' => \Yii::$app->user->can('createAnnouncement'), 'url' => ['/qux/announcement/index']],
            ['label' => '<i class="fa fa-folder"></i> Documents', 'visible' => \Yii::$app->user->can('createDocument'), 'items' => [
                ['label' => 'My Documents', 'url' => ['/qux/document/index']],
                ['label' => 'Receive', 'url' => ['/qux/document-status/receive']],
                ['label' => 'Release', 'url' => ['/qux/document-status/release']],
            ]],
            ['label' => '<i class="fa fa-users"></i> Users', 'visible' => \Yii::$app->user->can('createUser'), 'items' => [
                ['label' => 'Manage', 'url' => ['/qux/user/index']],
                ['label' => 'Activate', 'url' => ['/qux/user-profile/activate']],
                ['label' => 'Member Register', 'url' => ['/qux/user-profile/member-create']],
            ]],
            ['label' => '<i class="fa fa-bars"></i> Divisions', 'visible' => \Yii::$app->user->can('createDivision'), 'items' => [
                ['label' => 'Provincial', 'url' => ['/qux/provincial/index']],
                ['label' => 'Sector', 'url' => ['/qux/sector/index']],
                ['label' => 'Cluster', 'url' => ['/qux/cluster/index']],
                ['label' => 'Chapter', 'url' => ['/qux/chapter/index']],
            ]],
            ['label' => '<i class="fa fa-tasks"></i> Services', 'visible' => \Yii::$app->user->can('createService'), 'url' => ['/qux/service/index']],
            ['label' => Html::img(\Yii::$app->session->get('userProfile.url'), ['alt' => 'profile picture', 'height' => 20, 'style' => 'margin-right: 8px;']) . \Yii::$app->session->get('userProfile.name'), 'items' => [
                    [
                        'label' => 'Profile',
                        'url' => ['/qux/user-profile/view', 'id' => \Yii::$app->user->identity->id],
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

        <div class="search-box">
            <?= Html::beginForm(['/qux/default/search'], 'get') ?>
            <div class="input-group">
                <?= TypeaheadBasic::widget([
                    'name' => 'search',
                    'data' =>  $data,
                    'options' => ['placeholder' => 'Search for members'],
                    'pluginOptions' => ['highlight' => true],
                ]); ?>
                <span class="input-group-btn" title="Submit">
                    <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i>', ['class' => 'btn btn-primary']) ?>
                </span>
            </div>
            <?= Html::endForm() ?>
        </div>

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->params['appOwner'] . ' ' . date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
