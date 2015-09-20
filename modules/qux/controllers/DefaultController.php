<?php

namespace app\modules\qux\controllers;

use Yii;
use yii\web\Controller;
use app\models\AnnouncementSearch;
use app\models\UserProfileSearch;

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

    public function actionSearch()
    {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
