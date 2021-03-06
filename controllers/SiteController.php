<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Auth;
use app\models\User;
use app\models\UserProfile;
use app\models\Service;
use app\models\Cluster;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;
use app\models\LoginForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegister()
    {
        $user = new User();
        $userProfile = new UserProfile();
        $service = new Service();
        $cluster = new Cluster();

        $user->scenario = User::SCENARIO_GUEST_REGISTER;
        $userProfile->scenario = User::SCENARIO_GUEST_REGISTER;

        if ($user->load(Yii::$app->request->post()) && $userProfile->load(Yii::$app->request->post())) {
            $user->role = 'member';
            $transaction = $user->getDb()->beginTransaction();

            if ($user->save()) {
                $auth = Yii::$app->authManager;
                $authorRole = $auth->getRole($user->role);
                $auth->assign($authorRole, $user->id);

                $userProfile->user_id = $user->id;

                if ($userProfile->save()) {
                    $transaction->commit();

                    \Yii::$app->session->setFlash('contact-success', 'Thank you! Your information has been saved.');
                    return $this->redirect(['register']);
                }
            }
        }

        return $this->render('register', [
            'user' => $user,
            'userProfile' => $userProfile,
            'service' => $service,
            'cluster' => $cluster,
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/qux/default/index']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();

        $login = User::findByEmail($attributes['emails'][0]['value']);

        if (Yii::$app->user->isGuest) {
            if(is_null($login))
                throw new BadRequestHttpException('User account is not registered.');
            else {
                $userProfile = UserProfile::find()
                    ->where(['user_id' => $login->id])
                    ->limit(1)
                    ->one();

                $auth = Auth::find()
                    ->where(['source' => $client->getId()])
                    ->andWhere(['source_id' => $attributes['id']])
                    ->limit(1)
                    ->one();

                if ($auth === null) {
                    $modelAuth = new Auth();
                    $modelAuth->user_id = $login->id;
                    $modelAuth->source = $client->getId();
                    $modelAuth->source_id = $attributes['id'];
                    $modelAuth->save();
                }

                Yii::$app->user->login($login);

                if ($userProfile === null) {
                    $modelUserprofile = new UserProfile();
                    $modelUserprofile->scenario = UserProfile::SCENARIO_AUTH_REGISTER;
                    $modelUserprofile->user_id = $login->id;
                    $modelUserprofile->family_name = $attributes['name']['familyName'];
                    $modelUserprofile->given_name = $attributes['name']['givenName'];
                    $modelUserprofile->image = $attributes['image']['url'];
                    $modelUserprofile->save();
                }

                \Yii::$app->session->set('userProfile.url', ($userProfile === null) ? $modelUserprofile->image : $userProfile->image);
                \Yii::$app->session->set('userProfile.name', ($userProfile === null) ? $modelUserprofile->given_name : $userProfile->given_name);

                return $this->redirect(['qux/default/index']);
            }
        }
    }
}
