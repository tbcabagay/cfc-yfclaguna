<?php

namespace app\modules\qux\controllers;

use Yii;
use app\models\Document;
use app\models\DocumentStatus;
use app\models\DocumentStatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\filters\AccessControl;

/**
 * DocumentStatusController implements the CRUD actions for DocumentStatus model.
 */
class DocumentStatusController extends Controller
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
     * Displays a single DocumentStatus model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = Document::findOne($id);

        $query = DocumentStatus::find()
            ->joinWith(['document', 'document.user'])
            ->where(['document_status.document_id' => $id])
            ->andWhere('document_status.released_by IS NOT NULL')
            ->orderBy('document_status.received_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);


        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionReceive()
    {
        $searchModel = new DocumentStatusSearch();
        $dataProvider = $searchModel->receive();

        return $this->render('receive', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBulkReceive()
    {
        if (Yii::$app->request->isPost) {
            $selections = \Yii::$app->request->post('selection');
            $success = true;

            foreach ($selections as $selection) {
                $documentStatus = DocumentStatus::findOne($selection);
                $documentStatus->received_by = \Yii::$app->user->identity->id;
                $documentStatus->received_at = new Expression('NOW()');

                $success = $success && $documentStatus->save();

                if ($success) {
                    $document = Document::findOne($documentStatus->document_id);
                    $document->status = Document::FILE_RELEASE;
                    $success = $success && $document->save();
                }
            }

            if ($success)
                return $this->redirect(['receive']);
        }
    }

    public function actionRelease()
    {
        $searchModel = new DocumentStatusSearch();
        $dataProvider = $searchModel->release();

        return $this->render('release', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDoRelease($id)
    {
        $model = $this->findModel($id);
        $model->scenario = DocumentStatus::SCENARIO_DO_RELEASE;

        if ($model->load(Yii::$app->request->post())) {
            $model->attachment_file = UploadedFile::getInstance($model, 'attachment_file');
            $model->released_by = \Yii::$app->user->identity->id;
            $model->released_at = new Expression('NOW()');


            if($model->save()) {
                $model->upload();

                $document = Document::findOne($model->document_id);
                
                if ($model->action == DocumentStatus::ACTION_APPROVE) {
                    $document->status = Document::FILE_RECEIVE;
                } else if ($model->action == DocumentStatus::ACTION_DENY) {
                    $document->status = Document::FILE_DENY;
                } else if ((\Yii::$app->user->identity->division_label === 'provincial') && ($model->action == DocumentStatus::ACTION_APPROVE)) {
                    $document->status = Document::FILE_TERMINAL;
                }

                if ($document->save()) {
                    if (\Yii::$app->user->identity->division_label !== 'provincial') {
                        $findTo = $document->findToDivision();

                        $documentStatus = new DocumentStatus([
                            'document_id' => $model->document_id,
                            'from_id' => \Yii::$app->user->identity->division_id,
                            'from_label' => \Yii::$app->user->identity->division_label,
                            'to_id' => $findTo['id'],
                            'to_label' => $findTo['label'],
                        ]);

                        $documentStatus->save();
                    }

                    return $this->redirect(['release']);
                }
            }
            else
                print_r($model->getErrors());
        } else {
            return $this->render('do-release', [
                'model' => $model,
            ]);
        }
    }

    public function actionDownload($id)
    {
        $model = $this->findModel($id);

        return \Yii::$app->response->sendFile(Url::to($model->attachment));
        
    }

    /**
     * Finds the DocumentStatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DocumentStatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DocumentStatus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
