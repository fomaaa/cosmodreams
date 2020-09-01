<?php


namespace backend\components;

use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\base\Component;
use yii\imagine\Image;


class File extends Component
{
    private $base_path;

    public function __construct()
    {
        $this->base_path = str_replace('\\', '/',\Yii::getAlias('@storage') . '/web/source/user/');
    }

    public function upload($file, $user, $type)
    {
        if (!$file['error']) {
            if (!is_dir($folder = $this->base_path . $user->id)) {
                mkdir($folder, 0777);
                mkdir($folder . '/preview' , 0777);
            } else {
                $folder = $this->base_path . $user->id;
            }
            $ext = $type ?  '.mp4' :  '.png';
            $file_name = md5($file['name'] . time()  . $file['tmp_name']) . $ext;

            if (move_uploaded_file($file['tmp_name'], $folder . '/' . $file_name)) {
                $preview_folder = $folder . '/preview/';
                $this->doResize($folder . '/' . $file_name,  $preview_folder . $file_name);

                return $file_name;
            } else {
                return ['error' => 'Upload error #2'];
            }
        } else {
            return ['error' => 'Upload error #1'];
        }
    }

    public function doResize($imageLocation, $imageDestination, Array $options = null, $fq = false)
    {
        $image = new \Imagick(realpath($imageLocation));
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
        } else {
            $new_width = $options['newHeight'] / $old_height * $old_width;
            $new_height = $options['newHeight'];
            $crop_x = intval(($new_width - $options['newWidth']) / 2);
            $crop_y = 0;
        }

        $image->setImageCompressionQuality(95);

        if ($new_width && $new_height) {
            $image->resizeImage($new_width, $new_height, \Imagick::FILTER_LANCZOS, 1, false);
            $image->cropImage($options['newWidth'], $options['newHeight'], $crop_x, $crop_y);
        }

        $row = $image->getImageBlob();
        file_put_contents($imageDestination, $row);
    }

    public static function findDelimeter($name)
    {
        $a = substr_count($name, '/');
        $b = substr_count($name, '/');

        return $a > $b ? '/' : '/';
    }

}
