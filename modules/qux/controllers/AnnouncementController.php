<?php

namespace app\modules\qux\controllers;

use Yii;
use app\models\Comment;
use app\models\Announcement;
use app\models\AnnouncementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * AnnouncementController implements the CRUD actions for Announcement model.
 */
class AnnouncementController extends Controller
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
     * Lists all Announcement models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('createAnnouncement')) {
            $searchModel = new AnnouncementSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    /**
     * Displays a single Announcement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $comment = new Comment();
        $comment->scenario = Comment::SCENARIO_CREATE;

        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->where(['announcement_id' => $model->id])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if ($comment->load(Yii::$app->request->post())) {
            $comment->announcement_id = $model->id;
            $comment->save();
            return $this->redirect(['view', 'id' => $model->id, '#' => 'comments']);
        } else {
            return $this->render('view', [
                'model' => $model,
                'comment' => $comment,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Creates a new Announcement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createAnnouncement')) {
            $model = new Announcement();
            $model->scenario = Announcement::SCENARIO_CREATE;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    /**
     * Updates an existing Announcement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (\Yii::$app->user->can('updatePost', ['post' => $model])) {
                $model->save();
                return $this->redirect(['index']);
            } else {
                \Yii::$app->session->setFlash('update-error', 'You can\'t edit other user\'s annoucement post.');
                return $this->redirect(['update', 'id' => $model->id]);
            }

            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Announcement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (\Yii::$app->user->can('deletePost', ['post' => $model])) {
            $model->status = Announcement::STATUS_DELETE;
            $model->save();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Announcement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Announcement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Announcement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
