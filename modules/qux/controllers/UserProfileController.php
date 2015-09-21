<?php

namespace app\modules\qux\controllers;

use Yii;
use app\models\Cluster;
use app\models\User;
use app\models\Service;
use app\models\UserProfile;
use app\models\UserProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
        if (\Yii::$app->user->can('createUser')) {
            $searchModel = new UserProfileSearch();
            $dataProvider = $searchModel->inactive();

            return $this->render('activate', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    public function actionDoActivate($id)
    {
        if (\Yii::$app->user->can('createUser')) {
            $model = $this->findModel($id);
            $model->scenario = UserProfile::SCENARIO_ACTIVATE;

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $user = User::findOne($model->user_id);
                    $user->scenario = User::SCENARIO_ACTIVATE;
                    $user->status = User::STATUS_ACTIVE;

                    if ($user->save())
                        return $this->redirect(['activate']);
                }

            } else {
                return $this->render('do-activate', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    public function actionMemberCreate()
    {
        if (\Yii::$app->user->can('createUser')) {
            $user = new User();
            $userProfile = new UserProfile();
            $service = new Service();
            $cluster = new Cluster();

            $user->scenario = User::SCENARIO_MEMBER_CREATE;
            $userProfile->scenario = User::SCENARIO_MEMBER_CREATE;

            if ($user->load(Yii::$app->request->post()) && $userProfile->load(Yii::$app->request->post())) {
                $transaction = $user->getDb()->beginTransaction();

                if ($user->save()) {
                    $auth = Yii::$app->authManager;
                    $authorRole = $auth->getRole($user->role);
                    $auth->assign($authorRole, $user->id);

                    $userProfile->user_id = $user->id;

                    if ($userProfile->save()) {
                        $transaction->commit();

                        \Yii::$app->session->setFlash('contact-success', 'Thank you! Your information has been saved.');
                        return $this->redirect(['member-create']);
                    }
                }
            }

            return $this->render('member-create', [
                'user' => $user,
                'userProfile' => $userProfile,
                'service' => $service,
                'cluster' => $cluster,
            ]);
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
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
