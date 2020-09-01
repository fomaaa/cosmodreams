<?php

namespace backend\controllers;

use backend\models\Author;
use Yii;
use backend\models\Image3d;
use backend\models\search\Image3dSearchModel;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Image3dController implements the CRUD actions for Image3d model.
 */
class Image3dController extends Controller
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
     * Lists all Image3d models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Image3dSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Image3d model.
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
     * Creates a new Image3d model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Image3d();
        $author = Author::find()->select(['id', 'name'])->all();
        $author = ArrayHelper::map($author, 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
            $model->jpeg_hash = $this->getHashFile($model->jpeg_preview);
            $model->jpeg_preview = json_encode($model->jpeg_preview);
//            $model->asset_bundle = json_encode($model->asset_bundle);

            $model->save(false);
            return $this->redirect(['update', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'author' => $author
        ]);
    }

    /**
     * Updates an existing Image3d model.
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
            $model->jpeg_hash = $this->getHashFile($model->jpeg_preview);
            $model->jpeg_preview = json_encode($model->jpeg_preview);
//            $model->asset_bundle = json_encode($model->asset_bundle);

            $model->save(false);
            return $this->redirect(['update', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'author' => $author
        ]);
    }

    /**
     * Deletes an existing Image3d model.
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
     * Finds the Image3d model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Image3d the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Image3d::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function getHashFile($file)
    {
        $name = $file['path'];
        $name = explode('/', $name);
        $name = $name[count($name) - 1];

        $path = \Yii::getAlias('@storage'). '/web/source/1/' . $name;
        $path = str_replace('\\', '/', $path);

        return $hash = md5_file($path);
    }
}
