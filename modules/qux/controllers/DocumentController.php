<?php

namespace app\modules\qux\controllers;

use Yii;
use app\models\Document;
use app\models\DocumentSearch;
use app\models\DocumentStatus;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * DocumentController implements the CRUD actions for Document model.
 */
class DocumentController extends Controller
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
     * Lists all Document models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Document model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
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

        if ($model->load(Yii::$app->request->post())) {
            $model->attachment_file = UploadedFile::getInstance($model, 'attachment_file');

            if ($model->save() && $model->upload())
                return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
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
        $this->findModel($id)->delete();

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
