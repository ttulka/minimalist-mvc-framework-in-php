<?php
namespace app;

require_once 'mvc/Controller.php';

use mvc\Controller;

class HelloController extends Controller {

    function sayHello($params) {
        $this->addModelAttribute('user', $params['user']);
        $this->render('hello');
    }
}

