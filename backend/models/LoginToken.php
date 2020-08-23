<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "login_token".
 *
 * @property int $id
 * @property string $token
 * @property int $ip
 * @property string $time
 * @property string $type
 */
class LoginToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'login_token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'ip', 'type'], 'required'],
            [['ip'], 'integer'],
            [['expire'], 'safe'],
            [['token', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'ip' => 'Ip',
            'time' => 'Time',
            'type' => 'Type',
        ];
    }
}
