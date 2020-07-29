<?php

namespace backend\controllers;

use backend\models\Author;
use Yii;
use backend\models\Gallery2;
use backend\models\search\Gallery2SearchModel;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Gallery2Controller implements the CRUD actions for Gallery2 model.
 */
class Gallery2Controller extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Gallery2 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Gallery2SearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Gallery2 model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Gallery2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Gallery2();
        $author = Author::find()->select(['id', 'name'])->all();
        $author = ArrayHelper::map($author, 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
            $model->jpeg_hash = $this->getHashFile($model->jpeg);
            $model->jpeg_preview = json_encode($model->jpeg);
            $model->jpeg = json_encode($model->jpeg);

            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'author' => $author
        ]);
    }

    /**
     * Updates an existing Gallery2 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $author = Author::find()->select(['id', 'name'])->all();
        $author = ArrayHelper::map($author, 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
            $model->jpeg_hash = $this->getHashFile($model->jpeg);
            $model->jpeg_preview = json_encode($model->jpeg);
            $model->jpeg = json_encode($model->jpeg);

            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'author' => $author
        ]);
    }

    /**
     * Deletes an existing Gallery2 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Gallery2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gallery2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gallery2::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function getHashFile($file)
    {
        $name = $file['path'];
        $name = explode('\\', $name);
        $name = $name[count($name) - 1];

        $path = \Yii::getAlias('@storage'). '/web/source/1/' . $name;
        $path = str_replace('\\', '/', $path);

        return $hash = md5_file($path);
    }
}
