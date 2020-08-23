<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "logs".
 *
 * @property int $id
 * @property string $datetime
 * @property string|null $status_code
 * @property string|null $token
 * @property string $url
 * @property string|null $response
 * @property string|null $body
 * @property string|null $headers
 * @property string|null $method
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datetime'], 'safe'],
            [['url'], 'required'],
            [['response', 'body', 'headers'], 'string'],
            [['status_code', 'token', 'url'], 'string', 'max' => 255],
            [['method'], 'string', 'max' => 55],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datetime' => 'Datetime',
            'status_code' => 'Status Code',
            'token' => 'Token',
            'url' => 'Url',
            'response' => 'Response',
            'body' => 'Body',
            'headers' => 'Headers',
            'method' => 'Method',
        ];
    }
}
