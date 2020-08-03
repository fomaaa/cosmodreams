<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "statues".
 *
 * @property int $id
 * @property string|null $asset_bundle
 * @property string|null $name
 * @property string|null $author
 * @property string|null $description
 * @property string|null $jpeg_hash
 * @property string|null $jpeg_preview
 */
class Statues extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statues';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'jpeg_hash', 'name_en', 'description_en'], 'string'],
            [['asset_bundle', 'jpeg_preview'], 'safe'],
            [['name', 'author'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asset_bundle' => 'Asset Bundle',
            'name' => 'Название',
            'author' => 'Автор',
            'description' => 'Описание',
            'jpeg_preview' => 'Превью (128х128)',
            'name_en' => 'Название (en)',
            'description_en' => 'Описание (en)',
        ];
    }
}
