<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "3d_script".
 *
 * @property int $id
 * @property string|null $asset_bundle
 * @property string|null $name
 * @property string|null $author
 * @property string|null $description
 * @property string|null $jpeg_hash
 * @property string|null $jpeg_preview
 */
class Script3d extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '3d_script';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'jpeg_hash'], 'string'],
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
            'jpeg_preview' => 'Превью (128х128)'
        ];
    }
}
