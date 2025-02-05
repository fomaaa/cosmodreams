<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gallery".
 *
 * @property int $id
 * @property string|null $jpeg
 * @property string|null $name
 * @property string|null $author
 * @property string|null $description
 * @property string|null $jpeg_hash
 * @property string|null $jpeg_preview
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'jpeg_hash', 'jpeg_preview'], 'string'],
            [['jpeg', 'name', 'author', 'name_en', 'description_en'], 'string', 'max' => 255],
            [['AR'], 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jpeg' => 'Изображение',
            'name' => 'Название',
            'name_en' => 'Название (en)',
            'author' => 'Автор',
            'description' => 'Описание',
            'description_en' => 'Описание (en)',
            'AR' => 'есть AR'
        ];
    }
}
