<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gallery_2".
 *
 * @property int $id
 * @property string|null $jpeg
 * @property string|null $name
 * @property string|null $author
 * @property string|null $description
 * @property string|null $jpeg_hash
 * @property string|null $jpeg_preview
 */
class Gallery2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery_2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'jpeg_hash', 'jpeg_preview'], 'string'],
            [['jpeg', 'name', 'author', 'name_en', 'description_en'], 'string', 'max' => 255],
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
            'author' => 'Автор',
            'description' => 'Описание',
            'name_en' => 'Название (en)',
            'description_en' => 'Описание (en)',
        ];
    }
}
