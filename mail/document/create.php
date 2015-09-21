<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<p><?= $remarks ?></p>

<p>Please click on the link below to view the document.</p>

<p><?= Html::a(Url::to(['/qux/document/view', 'id' => $id], true), Url::to(['/qux/document/view', 'id' => $id], true)) ?></p>


