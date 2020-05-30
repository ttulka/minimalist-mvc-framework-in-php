<?php
namespace app;

require_once('./mvc/Dispatcher.php');

require_once('./controllers/HelloController.php');

use mvc\Dispatcher;

(new Dispatcher())
    ->routing('/hello/{user}', function($params) {
        (new HelloController())->sayHello($params);
    })
    ->dispatch();

