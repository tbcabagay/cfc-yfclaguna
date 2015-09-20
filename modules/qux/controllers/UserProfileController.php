<?php

namespace app\modules\qux\controllers;

use Yii;
use app\models\Cluster;
use app\models\User;
use app\models\UserProfile;
use app\models\UserProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays a single UserProfile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionActivate()
    {
        $searchModel = new UserProfileSearch();
        $cluster = new Cluster();
        $dataProvider = $searchModel->inactive();

        return $this->render('activate', [
            'dataProvider' => $dataProvider,
            'cluster' => $cluster,
        ]);
    }

    public function actionBulkActivate()
    {
        if (Yii::$app->request->isPost) {
            $selections = \Yii::$app->request->post('selection');
            $success = true;

            foreach ($selections as $selection) {
                $user = User::findOne($selection);
                $user->scenario = User::SCENARIO_ACTIVATE;
                $user->status = User::STATUS_ACTIVE;

                $success = $success && $user->save();
            }

            if ($success)
                return $this->redirect(['activate']);
            else
                print_r($user->getErrors());
        }
    }

    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = UserProfile::find()->with('user')->where(['user_id' => $id])->limit(1)->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
