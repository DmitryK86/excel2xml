<?php

namespace app\controllers;

use app\components\ExcelToXmlComponent;
use app\components\XmlComponent;
use app\models\FileForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new FileForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->upload()) {
                if ((new ExcelToXmlComponent($model->getPath()))->exportToXml()){
                    Yii::$app->session->setFlash('success', 'Успешно обработано');
                }
                else{
                    Yii::$app->session->setFlash('error', 'Ошибка обработки');
                }
            }
        }

        $showDownloadBtn = (new XmlComponent())->isFileExists();

        return $this->render('index', compact('model', 'showDownloadBtn'));
    }

    public function actionDownload(){
        (new XmlComponent())->getFile();
    }

    public function actionRefresh(){
        if ((new XmlComponent())->refresh()){
	        Yii::$app->session->setFlash('success', 'Успешно сброшено');
        }
        else{
	        Yii::$app->session->setFlash('error', 'Ошибка очистки данных');
        }
        return $this->redirect(Url::previous());
    }
}
