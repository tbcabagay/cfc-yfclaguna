<?php

namespace app\modules\qux\controllers;

use yii\web\Controller;
use app\models\AnnouncementSearch;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new AnnouncementSearch();
        $dataProvider = $searchModel->latest();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
