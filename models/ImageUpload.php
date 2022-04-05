<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    public $image;

    public function rules()
    {
        return[
          [['image'], 'required'],
          [['image'], 'file', 'extensions' => 'jpg,png']
        ];
    }

    public function uploadedFile($file, $currentImage)
    {
        $this->image = $file;

        // проверка что это картинка
        if($this->validate())
        {
            // удаляем старую и загружаем новую
            $this->deleteCurrentImage($currentImage);
            return $this->saveImage();
        }
    }

    private function getFolder()
    {
        // возвращает ссылку на папку с загрузками
        return Yii::getAlias('@web') . 'uploads/';
    }

    private function generateFilename()
    {
        // генерация имени для картинки
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    public function deleteCurrentImage($currentImage)
    {
        // проверяем если ли такой файл и если есть то удаляем его
        if($this->isFileExist($currentImage))
        {
            unlink($this->getFolder() . $currentImage);
        }
    }

    public function isFileExist($currentImage)
    {
        // проверка на существование
        return is_file($this->getFolder() . $currentImage);
    }

    public function saveImage()
    {
        // генерируем имя файла для загруженной картинки
        // сохранияем и возвращаем имя этого файла
        $filename = $this->generateFilename();
        $this->image->saveAs($this->getFolder() . $filename);
        return $filename;
    }
}