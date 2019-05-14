<?php

namespace ozerich\admin\widgets;

class TinyMce extends \dosamigos\tinymce\TinyMce
{
    public $language = 'ru';

    public $enabledImagesUpload = false;

    public $imagesUploadUrl = '/admin/default/upload-tinymce';

    public $clientOptions = [
        'height' => 800,
        'plugins' => [
            "image imagetools",
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
        'imagetools_toolbar' => "rotateleft rotateright | flipv fliph | editimage imageoptions",
        'automatic_uploads' => false,
    ];

    public function init()
    {
        if ($this->enabledImagesUpload) {
            $this->clientOptions['images_upload_url'] = $this->imagesUploadUrl;
            $this->clientOptions['toolbar'] .= ' | image';
        }

        parent::init();
    }
}