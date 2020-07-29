<?php

namespace backend\controllers;

use backend\models\Author;
use backend\models\Gallery;
use backend\models\Gallery2;
use backend\models\Image3d;
use backend\models\Masks;
use backend\models\Script3d;
use backend\models\Statues;
use Yii;
use yii\web\Response;

class ApiController extends \yii\web\Controller
{
    public function actionGetContentData()
    {
        $data['author'] = Author::find()->asArray()->all();
        $data['statues'] = Statues::find()->asArray()->all();
        $data['images'] = Image3d::find()->asArray()->all();
        $data['scripts'] = Script3d::find()->asArray()->all();
        $data['masks'] = Masks::find()->asArray()->all();
        $data['gallery'] = Gallery::find()->asArray()->all();
        $data['gallery2'] = Gallery2::find()->asArray()->all();

        foreach ($data['statues'] as $key => $item) {
            $data['statues'][$key]['asset_bundle'] = $this->setBundle($item['asset_bundle']);
            $data['statues'][$key]['jpeg_preview'] = $this->setImage($item['jpeg_preview']);
        }

        foreach ($data['images'] as $key => $item) {
            $data['images'][$key]['asset_bundle'] = $this->setBundle($item['asset_bundle']);
            $data['images'][$key]['jpeg_preview'] = $this->setImage($item['jpeg_preview']);
        }

        foreach ($data['masks'] as $key => $item) {
            $data['masks'][$key]['asset_bundle'] = $this->setBundle($item['asset_bundle']);
            $data['masks'][$key]['jpeg_preview'] = $this->setImage($item['jpeg_preview']);
        }

        foreach ($data['gallery'] as $key => $item) {
            $data['gallery'][$key]['jpeg'] = $this->setImage($item['jpeg']);
            $data['gallery'][$key]['jpeg_preview'] = $this->setImage($item['jpeg_preview']);
        }

        foreach ($data['gallery2'] as $key => $item) {
            $data['gallery2'][$key]['jpeg'] = $this->setImage($item['jpeg']);
            $data['gallery2'][$key]['jpeg_preview'] = $this->setImage($item['jpeg_preview']);
        }

        return $data;
    }
    private function setImage($file)
    {
        $file = json_decode($file, true);
        $name = $file['base_url'] . $file['path'];

        return str_replace('\\', '/', $name);
    }
    
    
    private function setBundle($file)
    {
        $file = json_decode($file, true);
        $name = explode('\\', $file['path']);
        $name = $name[count($name) - 1];

        $bundle =   Yii::getAlias('@storage') . '\web\source\1\assets_bundle\\' . $name;
        $bundle = str_replace('\\', '/', $bundle . $name);

        return $bundle;
    }

    public $headers;
    public $body;
    public $method;
    public $token;
    public $user;

    public function beforeAction($action)
    {
        $headers = Yii::$app->request->headers;

        $this->enableCsrfValidation = false;
        $this->headers = $_SERVER;
        $this->body = file_get_contents('php://input');

        $this->token = str_replace('Bearer ', '', $headers->get('Authorization'));

        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Methods', 'GET,DELETE,HEAD,OPTIONS,POST,PUT');
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Headers', '*');
            Yii::$app->response->statusCode = 204;
            Yii::$app->end();
        } else {
            \Yii::$app->response->format = Response::FORMAT_JSON;
        }

        return parent::beforeAction($action);
    }


}
