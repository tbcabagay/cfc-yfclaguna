<?php

namespace app\modules\qux\controllers;

use Yii;
use app\models\Document;
use app\models\DocumentSearch;
use app\models\DocumentStatus;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use app\models\User;

/**
 * DocumentController implements the CRUD actions for Document model.
 */
class DocumentController extends Controller
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
     * Lists all Document models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('createDocument')) {
            $searchModel = new DocumentSearch();
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
     * Displays a single Document model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('createDocument')) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    public function actionCreate()
    {
        if (\Yii::$app->user->can('createDocument')) {
            $model = new Document();
            $model->scenario = Document::SCENARIO_CREATE;

            if ($model->load(Yii::$app->request->post())) {
                $model->attachment_file = UploadedFile::getInstance($model, 'attachment_file');

                if ($model->save() && $model->upload()) {
                    $transaction = $model->getDb()->beginTransaction();
                    $findTo = $model->findToDivision();

                    $documentStatus = new DocumentStatus([
                        'document_id' => $model->id,
                        'from_id' => \Yii::$app->user->identity->division_id,
                        'from_label' => \Yii::$app->user->identity->division_label,
                        'to_id' => $findTo['id'],
                        'to_label' => $findTo['label'],
                    ]);

                    if ($documentStatus->save()) {
                        $transaction->commit();

                        $recipients = User::find()
                            ->select(['email'])
                            ->where('division_id=:division_id AND division_label=:division_label AND username IS NULL')
                            ->addParams([
                                ':division_id' => $findTo['id'],
                                ':division_label' => $findTo['label'],
                            ])
                            ->asArray()
                            ->all();

                        $messages = [];

                        foreach ($recipients as $recipient) {
                            $messages[] = Yii::$app->mailer->compose('document/create', ['id' => $model->id, 'remarks' => $model->remarks])
                                ->setFrom(\Yii::$app->params['mailer'])
                                ->setTo($recipient['email'])
                                ->setSubject($model->user->full_name . ' - ' . $model->title);
                        }

                        \Yii::$app->mailer->sendMultiple($messages);

                        return $this->redirect(['index']);
                    }

                    print_r($documentStatus->getErrors());
                }

                print_r($model->getErrors());
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
     * Updates an existing Document model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Document::SCENARIO_UPDATE;

        if (\Yii::$app->user->can('updatePost', ['post' => $model])) {
            if ($model->load(Yii::$app->request->post())) {
                $model->attachment_file = UploadedFile::getInstance($model, 'attachment_file');

                if ($model->status != Document::FILE_NEW) {
                    \Yii::$app->session->setFlash('update-error', 'Can\' update a document that has already been received by other offices.');
                } else {
                    $model->save();
                    $model->upload();
                }

                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page');
        }
    }

    /**
     * Deletes an existing Document model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (\Yii::$app->user->can('deletePost', ['post' => $model])) {
            $model->delete();
            $model->deleteFile();
        }

        return $this->redirect(['index']);
    }

    public function actionDownload($id)
    {
        $model = Document::findOne($id);

        if (is_null($model))
            throw new NotFoundHttpException('The requested file does not exist.');
        else
            return \Yii::$app->response->sendFile(Url::to($model->attachment));
        
    }

    /**
     * Finds the Document model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Document the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Document::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
