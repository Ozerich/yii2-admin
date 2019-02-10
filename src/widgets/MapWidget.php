<?php

namespace ozerich\admin\widgets;

use yii\widgets\InputWidget;

class MapWidget extends InputWidget
{
    /** @var  array */
    public $center;

    /** @var integer */
    public $zoom;

    public function run()
    {
        return $this->render('map', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'zoom' => $this->zoom,
            'center' => $this->center
        ]);
    }
}