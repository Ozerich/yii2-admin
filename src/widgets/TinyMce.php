<?php

namespace ozerich\admin\widgets;

class TinyMce extends \dosamigos\tinymce\TinyMce
{
    public $language = 'ru';

    public $options = [
        'rows' => 20
    ];

    public $clientOptions = [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ];
}