<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_data".
 *
 * @property int $id
 * @property int $user_id
 * @property string $type 0 - фото, 1 - видео
 * @property string $file
 * @property string $created_at
 * @property string|null $deleted_at
 */
class UserData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'file'], 'required'],
            [['user_id'], 'integer'],
            [['type', 'file'], 'string'],
            [['created_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'file' => 'File',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
