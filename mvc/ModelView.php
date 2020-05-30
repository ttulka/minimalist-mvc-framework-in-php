<?php
namespace mvc;

class ModelView {

    private $_name;
    private $_model;
    private $_type;

    public function __construct($name, $model, $type = 'html') {
        $this->_name = $name;
        $this->_model = $model;
        $this->_type = $type;
    }

    public final function render() {
        switch ($this->_type) {
            case 'xml':
                header('Content-type: text/xml; charset=UTF-8');
                break;
            case 'json':
                header("Content-Type: application/json; charset=UTF-8");
                break;
            default:
                header("Content-Type: text/html; charset=UTF-8");
        }
        require_once "./views/layouts/{$this->_type}.php";
    }

    public final function content() {
        ob_start();
        require_once "./views/{$this->_name}.php";
        $out = ob_get_contents();
        ob_end_clean();

        return $out;
    }

    public final function __get($key) {
        return isset($this->_model[$key]) ? $this->_model[$key] : "__{$key}__";
    }
}

