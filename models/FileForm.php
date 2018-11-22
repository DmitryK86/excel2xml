<?php
namespace app\models;


use yii\base\Model;
use yii\web\UploadedFile;

class FileForm extends Model
{
    /** @var UploadedFile $file */
    public $file;

    protected $path;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Загрузить файл',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->path = 'uploads/' . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs($this->path);
            return true;
        } else {
            return false;
        }
    }

    public function getPath(){
        return $this->path;
    }
}