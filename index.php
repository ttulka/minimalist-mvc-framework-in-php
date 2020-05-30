<?php
require_once('./mvc/Dispatcher.php');

use mvc\Dispatcher;

(new Dispatcher())
    ->routing('/hello/{name}', function($params) {
        echo "Hello, {$params['name']}!";
    })
    ->dispatch();

