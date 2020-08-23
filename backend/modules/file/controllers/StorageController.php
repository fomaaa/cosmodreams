<?php

namespace backend\modules\file\controllers;

use backend\modules\file\models\search\FileStorageItemSearch;
use common\models\FileStorageItem;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StorageController extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'upload-delete' => ['delete'],
                ],
            ],
        ];
    }

    /** @inheritdoc */
    public function actions()
    {
        return [
            'upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'upload-delete',
            ],
            'upload-with-thumb256' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'upload-delete',
                'on afterSave' => function ($event) {
                    $file = $event->file;
                    $path = Yii::getAlias('@storage') . '\web\source\1\\';
                    $thumb = Yii::getAlias('@storage') . '/web/source/1/preview256/';
//                    $bundle = Yii::getAlias('@storage') . '\web\source\1\preview256\\';
                    $name = $file->getPath();
                    $name = explode('\\', $name);
                    $name = $name[count($name) - 1];
                    $path = str_replace('\\', '/', $path . $name);
//                    $bundle = str_replace('\\', '/', $bundle . $name);
                    $image = new \Imagick($path);
                    $options = [
                        'quality' => 95,
                        'newWidth' => 256,
                        'newHeight' => 256
                    ];
                    $ratio = $options['newWidth'] / $options['newHeight'];
                    $old_width = $image->getImageWidth();
                    $old_height = $image->getImageHeight();
                    $old_ratio = $old_width / $old_height;


                    if ($ratio > $old_ratio) {
                        $new_width = $options['newWidth'];
                        $new_height = $options['newWidth'] / $old_width * $old_height;
                        $crop_x = 0;
                        $crop_y = intval(($new_height - $options['newHeight']) / 2);
                    }
                    else {
                        $new_width = $options['newHeight'] / $old_height * $old_width;
                        $new_height = $options['newHeight'];
                        $crop_x = intval(($new_width - $options['newWidth']) / 2);
                        $crop_y = 0;
                    }

                    $image->setImageCompressionQuality(80);

                    if ($new_width && $new_height) {
                        $image->resizeImage($new_width, $new_height, \Imagick::FILTER_LANCZOS, 1, false);
                        $image->cropImage($options['newWidth'], $options['newHeight'], $crop_x, $crop_y);
                    }

                    $row = $image->getImageBlob();
//                    echo $thumb . $image_name;
                    file_put_contents($thumb . $name, $row);
                }
            ],
            'upload-assets' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'upload-delete',
                'on afterSave' => function ($event) {
                    $file = $event->file;
                    $path = Yii::getAlias('@storage') . '\web\source\1\\';
                    $bundle = Yii::getAlias('@storage') . '\web\source\1\assets_bundle\\';
                    $name = $file->getPath();
                    $name = explode('\\', $name);
                    $name = $name[count($name) - 1];
                    $path = str_replace('\\', '/', $path . $name);
                    $bundle = str_replace('\\', '/', $bundle . $name);
                    copy($path, $bundle);
                }
            ],
            'upload-delete' => [
                'class' => DeleteAction::class,
            ],
            'upload-imperavi' => [
                'class' => UploadAction::class,
                'fileparam' => 'file',
                'responseUrlParam' => 'filelink',
                'multiple' => false,
                'disableCsrf' => true,
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileStorageItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC],
        ];
        $components = ArrayHelper::map(
            FileStorageItem::find()->select('component')->distinct()->all(),
            'component',
            'component'
        );
        $totalSize = FileStorageItem::find()->sum('size') ?: 0;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'components' => $components,
            'totalSize' => $totalSize,
        ]);
    }

    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     *
     * @return FileStorageItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FileStorageItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
