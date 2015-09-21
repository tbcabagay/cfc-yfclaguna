<?php

namespace app\modules\qux\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\Service;
use app\models\Chapter;
use app\models\Cluster;
use app\models\Sector;
use app\models\Provincial;
use yii\helpers\Json;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('createUser')) {
            $service = new Service();
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'service' => $service,
            ]);
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('createUser')) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createUser')) {
            $model = new User();
            $service = new Service();

            $model->scenario = User::SCENARIO_ADMIN_USER_REGISTER;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $auth = Yii::$app->authManager;
                $authorRole = $auth->getRole($model->role);
                $auth->assign($authorRole, $model->id);

                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'service' => $service,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('createUser')) {
            $model = $this->findModel($id);
            $service = new Service();

            $model->scenario = User::SCENARIO_ADMIN_USER_REGISTER;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'service' => $service,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('createUser')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    public function actionDivision()
    {
        if (\Yii::$app->user->can('createUser')) {
            $out = [];

            if (isset($_POST['depdrop_parents'])) {
                $parents = $_POST['depdrop_parents'];

                if ($parents != null) {
                    $division = $parents[0];
                    $out = $this->getDivisionList($division);
                    echo Json::encode(['output'=>$out, 'selected'=>'']);
                    return;
                }
            }

            echo Json::encode(['output'=>'', 'selected'=>'']);
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getDivisionList($division)
    {
        $result = [];
        $model = '';

        if ($division === 'provincial') {
            $model = Provincial::find()->orderBy('label ASC')->all();
            $result = $this->prepDivisionList($model);
        } else if ($division === 'sector') {
            $model = Sector::find()->orderBy('label ASC')->all();
            $result = $this->prepDivisionList($model);
        } else if ($division === 'cluster') {
            $model = Cluster::find()->orderBy('label ASC')->all();
            $result = $this->prepDivisionList($model);
        } else if ($division === 'chapter') {
            $model = Chapter::find()->orderBy('label ASC')->all();
            $result = $this->prepDivisionList($model);
        }

        return $result;
    }

    protected function prepDivisionList($data)
    {
        $result = [];

        foreach ($data as $item) {
            $result[] = [
                'id' => $item['id'],
                'name' => $item['label'],
            ];
        }

        return $result;
    }
}
