<?php
namespace mvc;

require_once 'mvc/ModelView.php';

abstract class Controller {

    private $model = [];

    function render($name, $type = 'html') {
        (new ModelView($name, $this->model, $type))->render();
    }

    function addModelAttribute($key, $value) {
        $this->model[$key] = $value;
    }
}

