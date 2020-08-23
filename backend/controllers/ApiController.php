<?php

namespace backend\controllers;

use backend\models\Author;
use backend\models\Gallery;
use backend\models\Gallery2;
use backend\models\Image3d;
use backend\models\LoginToken;
use backend\models\Logs;
use backend\models\Masks;
use backend\models\Script3d;
use backend\models\Statues;
use backend\models\UserData;
use common\models\User;
use Yii;
use yii\web\Response;

class ApiController extends \yii\web\Controller
{
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
        $this->token = $headers->get('Authorization');
        $this->user = User::find()->where(['access_token' => $this->token])->one();

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

    public function actionUploadUserData()
    {
        if ($this->checkMethod('Post')) {
            if ($error = $this->checkToken()) return $this->error('403', ['message' => $error]);
            $fields = ['type'];
            $error = array();
            foreach ($fields as $key => $item) {
                if (!isset($_POST[$item])) {
                    $error[] = 'Field ' . $item . '  required';
                }
            }
            if (!$file = $_FILES['media'])  $error[] = 'Media  required';
            if ($error) return $this->error('422', ['status' => 'validation error', 'message' => $error]);
            $file = Yii::$app->file->upload($file, $this->user, $_POST['type']);

            if (is_array($file) && $file['error']) return $this->error('422', ['status' => 'validation error', 'message' => $file['error']]);

            $data = new UserData();
            $data->user_id = $this->user->id;
            $data->type = (int) $_POST['type'];
            $data->file = Yii::getAlias('@backendUrl') . '/images/' . $file;
            $data->save(false);

            return $this->response('201', ['status' => 'success', 'data' => $data]);
        } else {
            return $this->error('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionGetContentData()
    {
        if ($error = $this->checkToken()) return $this->error('403', ['message' => $error]);

        $data['author'] = Author::find()->asArray()->all();
        $data['statues'] = Statues::find()->asArray()->all();
        $data['images'] = Image3d::find()->asArray()->all();
        $data['scripts'] = Script3d::find()->asArray()->all();
        $data['masks'] = Masks::find()->asArray()->all();
        $data['gallery'] = Gallery::find()->asArray()->all();
        $data['gallery2'] = Gallery2::find()->asArray()->all();

        foreach ($data['statues'] as $key => $item) {
//            $data['statues'][$key]['asset_bundle'] = $this->setBundle($item['asset_bundle']);
            $data['statues'][$key]['jpeg_preview'] = $this->setImage($item['jpeg_preview']);
        }

        foreach ($data['scripts'] as $key => $item) {
//            $data['scripts'][$key]['asset_bundle'] = $this->setBundle($item['asset_bundle']);
            $data['scripts'][$key]['jpeg_preview'] = $this->setImage($item['jpeg_preview']);
        }

        foreach ($data['images'] as $key => $item) {
//            $data['images'][$key]['asset_bundle'] = $this->setBundle($item['asset_bundle']);
            $data['images'][$key]['jpeg_preview'] = $this->setImage($item['jpeg_preview']);
        }

        foreach ($data['masks'] as $key => $item) {
//            $data['masks'][$key]['asset_bundle'] = $this->setBundle($item['asset_bundle']);
            $data['masks'][$key]['jpeg_preview'] = $this->setImage($item['jpeg_preview']);
        }

        foreach ($data['gallery'] as $key => $item) {
            $data['gallery'][$key]['jpeg'] = $this->setImage($item['jpeg']);
            $data['gallery'][$key]['jpeg_preview'] = $this->getImagePreview($item['jpeg']);
        }

        foreach ($data['gallery2'] as $key => $item) {
            $data['gallery2'][$key]['jpeg'] = $this->setImage($item['jpeg']);
            $data['gallery2'][$key]['jpeg_preview'] = $this->getImagePreview($item['jpeg']);
        }


        return $this->response(200, $data);
    }

    private function checkToken()
    {
        if (!$this->token) return 'Missing Authorization Token';
        if (!$this->user) return 'Authorization token is not valid';

        return false;
    }
    public function actionToken()
    {
        if ($this->checkMethod('Post')) {
            $body = $this->getBody();
            $client_secret = env('API_KEY');
            if ($client_secret != $body['client_secret']) {
                return $this->error('403', ['message' => 'Access denied']);
            }
            LoginToken::deleteAll(['<', 'expire', time()]);
            $token = new LoginToken;
            $token->token = $this->generateRandomString(25);
            $token->expire = time() + 360;
            $token->ip = $this->getIP();
            $token->type = 'login';
            if ($token->save(false)) {
                $response = ['token' => $token->token, 'expire' => 360];
            }

            return $this->response('201', $response);
        } else {
            return $this->error('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionLogin()
    {
        if ($this->checkMethod('Post')) {
            $body = $this->getBody();
            $fields = ['login', 'device_id'];
            $error = array();
            foreach ($fields as $key => $item) {
                if (!$body[$item]) {
                    $error[] = 'Field ' . $item . '  required';
                }
            }
            if ($error) return $this->error('422', ['status' => 'validation error', 'message' => $error]);
            if ( $token =  LoginToken::find()->where(['token' => $body['login_token']])
//                ->andWhere(['>', 'expire', time()])
                ->one()) {
//                $token->delete();
                if (!$user = User::findByUsername($body['login'])) {
                    $user = new User();
                    $user->username = $body['login'];
                    $user->status = 2;
                    $user->device_id = $body['device_id'];
                    $user->setPassword($body['password']);
                    $user->auth_key = Yii::$app->getSecurity()->generatePasswordHash($body['password']);

                    $user->access_token = md5(sha1($body['login'] . $body['password'] . time() . rand(0, 99999)));
                    if (!$user->validate()) {
                        $error = $user->getErrors();
                        return $this->response('422', $error);
                    }
                    $user->save(false);
                }

                $response = ['authToken' => $user->access_token, 'userData' => $this->getUserObject($user->id)];
                return $this->response('200', $response);
            } else {
                return $this->error('403', ['message' => 'Access denied']);
            }
        } else {
            return $this->error('405', ['message' => 'Method Not Allowed']);
        }
    }

    public function actionUser($id)
    {

    }


    private function getUserObject($id)
    {
        return [
            'user_id' => $id,
            'accounts' => [],
            'video' => [],
            'video_preview' => [],
            'photos' => [],
            'photo_preview' => [],
            'mediaId' => id
        ];
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

        return $name;
    }

    private function getBody()
    {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body) {
            exit(json_encode($this->error('422', ['message' => 'Empty or not valid json'])));
        }

        return $body;
    }

    private function getImagePreview($file) {
        $data = json_decode($file, true);
        $thumb = Yii::getAlias('@storage') . '\web\source\1\preview256\\';
        $url = Yii::getAlias('@storageUrl') . '/source/1/preview256/';

        if (is_array($data)) {
            $filename = explode('\\', $data['path']);
        }
        $image_name = $filename[count($filename) - 1];


        if (file_exists($thumb . $image_name)) {
            return $url . $image_name;
        } else {
            return $this->setImage($file);
        }
    }

    private function log($params)
    {
        $log = new Logs();

        $log->status_code = $params['status_code'];
        $log->url = $params['url'];
        $log->response = $params['response'];
        $log->body = $params['body'];
        $log->headers = $params['headers'];
        $log->method = $params['method'];
        $log->token = $params['token'];
        $log->	datetime = date('Y-m-d H:i:s');

        $log->save(false);
    }

    private function error($statusCode, $params = array())
    {
        Yii::$app->response->statusCode = $statusCode;

        $this->log([
            'status_code' => (int)$statusCode,
            'url' => (string)(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            'response' => json_encode($params),
            'body' => json_encode($this->body),
            'headers' => json_encode($this->headers),
            'method' => $this->method,
            'token' => $this->token
        ]);

        return ['error' => $params];

    }

    private function checkNumericInArray($data)
    {
        foreach ($data as $key => $item) {
            if (is_numeric($item)) {
                $data[$key] = (float)$item;
            } elseif(is_string($item)) {
                $data[$key] = nl2br($item);
//                    $data[$key] = preg_replace('~[\r\n]+~', '',  $data[$key]);
                $data[$key] = str_replace(array("\r\n","\r"),'', $data[$key]);;
            }
            if (is_array($item)) {
                $data[$key] = $this->checkNumericInArray($item);
            }
        }
        return $data;
    }

    private function response($statusCode, $data)
    {
        if ($data) {
            foreach ($data as $key => $item) {
                if($key == 'phone' || $key == 'status') continue;
                if (is_numeric($item)) {
                    $data[$key] = (float)$item;
                } elseif(is_string($item)) {
                    $data[$key] = nl2br($item);
                }

                if (is_array($item)) {
                    $data[$key] = $this->checkNumericInArray($item);
                }
            }
        }

        Yii::$app->response->statusCode = $statusCode;
        $this->log([
            'status_code' => (int)$statusCode,
            'url' => (string)(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            'response' => json_encode($data),
            'body' => json_encode($this->body),
            'headers' => json_encode($this->headers),
            'method' => $this->method,
            'token' => $this->token
        ]);
        return $data;
    }

    private function checkMethod($method)
    {
        if (Yii::$app->request->{'is' . $method}) {
            $status = true;
            $this->method = $method;
        } else {
            $status = false;
        }
        return $status;
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function getIP() {
        if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
                $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}
