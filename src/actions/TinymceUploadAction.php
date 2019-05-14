<?php

namespace ozerich\admin\actions;

use ozerich\filestorage\actions\UploadAction;
use ozerich\filestorage\models\File;

class TinymceUploadAction extends UploadAction
{
    public $scenario = 'tinymce';

    public function init()
    {
        $this->responseFormatter = function (File $image) {
            return [
                'success' => true,
                'location' => $image->getUrl(),
                'image' => $image->toJSON()
            ];
        };

        parent::init();
    }
}