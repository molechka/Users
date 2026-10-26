<?php

namespace user\models;

use yii\web\UploadedFile;
use yii\base\Model;

class UploadImage extends Model {

    /**
     * @var UploadedFile
     */
    public $avatar;

    public function rules() {
        return [
            [['avatar'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxSize' => 153600],
        ];
    }

    public function upload() {
        if ($this->validate()) {
            $filepath = '/tmp/files/' . $this->avatar->baseName . '.' . $this->avatar->extension;
            $this->avatar->saveAs($_SERVER['DOCUMENT_ROOT'] . $filepath);
            return $filepath;
        } else {
            return false;
        }
    }

}
